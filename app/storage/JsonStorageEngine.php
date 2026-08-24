<?php
declare(strict_types=1);

namespace App\Storage;

/**
 * Enterprise JSON Storage Engine V3
 * Features: Atomic I/O, flock Concurrency Control, Safe Tempfile Swapping, Reference Number Counter
 */
class JsonStorageEngine
{
    private string $dataDir;
    private static ?self $instance = null;
    private array $inMemoryCache = [];
    private bool $inTransaction = false;
    private array $transactionBackups = [];

    public function __construct(?string $dataDir = null)
    {
        $this->dataDir = $dataDir ?? app_config('app.data_path', dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'data');
        $this->ensureStorageReady();
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Ensure data directories and essential collection files exist
     */
    private function ensureStorageReady(): void
    {
        if (!is_dir($this->dataDir)) {
            mkdir($this->dataDir, 0755, true);
        }

        $htaccess = $this->dataDir . DIRECTORY_SEPARATOR . '.htaccess';
        if (!file_exists($htaccess)) {
            file_put_contents($htaccess, "Require all denied\nDeny from all\n");
        }

        $indexesDir = $this->dataDir . DIRECTORY_SEPARATOR . 'indexes';
        if (!is_dir($indexesDir)) {
            mkdir($indexesDir, 0755, true);
        }

        // Initialize essential collections if missing
        $collections = ['users', 'tickets', 'assets', 'audit_logs', 'counters'];
        foreach ($collections as $col) {
            $file = $this->getFilePath($col);
            if (!file_exists($file)) {
                $initialData = ($col === 'counters') ? ['tickets' => 0] : [];
                $this->writeRaw($col, $initialData);
            }
        }
    }

    /**
     * Get path for a specific collection
     */
    public function getFilePath(string $collection): string
    {
        return $this->dataDir . DIRECTORY_SEPARATOR . $collection . '.json';
    }

    /**
     * Read collection data with shared read lock (LOCK_SH)
     */
    public function read(string $collection): array
    {
        $file = $this->getFilePath($collection);
        if (!file_exists($file)) {
            return [];
        }

        $fp = fopen($file, 'rb');
        if (!$fp) {
            return [];
        }

        flock($fp, LOCK_SH);
        $content = stream_get_contents($fp);
        flock($fp, LOCK_UN);
        fclose($fp);

        if (empty($content)) {
            return [];
        }

        $decoded = json_decode($content, true);
        return is_array($decoded) ? $decoded : [];
    }

    /**
     * Write collection data atomically with exclusive lock (LOCK_EX) and temporary file swap
     */
    public function write(string $collection, array $data): bool
    {
        if ($this->inTransaction && !isset($this->transactionBackups[$collection])) {
            $this->transactionBackups[$collection] = $this->read($collection);
        }

        return $this->writeRaw($collection, $data);
    }

    /**
     * Low-level atomic write implementation
     */
    private function writeRaw(string $collection, array $data): bool
    {
        $targetFile = $this->getFilePath($collection);
        $tempFile = tempnam($this->dataDir, 'json_tmp_');

        if ($tempFile === false) {
            throw new \RuntimeException("Gagal mencipta fail sementara untuk penulisan JSON: {$collection}");
        }

        $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        // Open temp file with exclusive lock
        $fp = fopen($tempFile, 'wb');
        if (!$fp) {
            @unlink($tempFile);
            return false;
        }

        flock($fp, LOCK_EX);
        fwrite($fp, $jsonData);
        fflush($fp);
        flock($fp, LOCK_UN);
        fclose($fp);

        // Atomic swap
        if (!rename($tempFile, $targetFile)) {
            // Windows fallback: unlink target then rename
            @unlink($targetFile);
            if (!rename($tempFile, $targetFile)) {
                @unlink($tempFile);
                throw new \RuntimeException("Gagal menukar ganti fail data: {$collection}");
            }
        }

        return true;
    }

    /**
     * Insert a new record into collection
     */
    public function insert(string $collection, array $record): array
    {
        if (empty($record['id'])) {
            $record['id'] = $this->generateUuid();
        }

        $record['created_at'] = $record['created_at'] ?? date('c');
        $record['updated_at'] = date('c');

        $data = $this->read($collection);
        $data[] = $record;
        $this->write($collection, $data);

        return $record;
    }

    /**
     * Update an existing record by ID
     */
    public function update(string $collection, string $id, array $attributes): ?array
    {
        $data = $this->read($collection);
        $updatedRecord = null;

        foreach ($data as $index => $item) {
            if (($item['id'] ?? null) === $id) {
                $attributes['updated_at'] = date('c');
                $data[$index] = array_merge($item, $attributes);
                $updatedRecord = $data[$index];
                break;
            }
        }

        if ($updatedRecord !== null) {
            $this->write($collection, $data);
        }

        return $updatedRecord;
    }

    /**
     * Delete a record by ID
     */
    public function delete(string $collection, string $id): bool
    {
        $data = $this->read($collection);
        $initialCount = count($data);

        $filtered = array_values(array_filter($data, function ($item) use ($id) {
            return ($item['id'] ?? null) !== $id;
        }));

        if (count($filtered) !== $initialCount) {
            $this->write($collection, $filtered);
            return true;
        }

        return false;
    }

    /**
     * Find single record by ID
     */
    public function find(string $collection, string $id): ?array
    {
        $data = $this->read($collection);
        foreach ($data as $item) {
            if (($item['id'] ?? null) === $id) {
                return $item;
            }
        }
        return null;
    }

    /**
     * Generate structured reference number for tickets (e.g. ICTBKP/2026/08/0001)
     */
    public function nextReferenceNumber(string $prefix = 'ICTBKP'): string
    {
        $year = date('Y');
        $month = date('m');
        $counterKey = "tickets_{$year}_{$month}";

        $counters = $this->read('counters');
        $current = ($counters[$counterKey] ?? 0) + 1;
        $counters[$counterKey] = $current;
        $this->write('counters', $counters);

        $runningNumber = str_pad((string)$current, 4, '0', STR_PAD_LEFT);
        return "{$prefix}/{$year}/{$month}/{$runningNumber}";
    }

    /**
     * Generate standard UUID v4
     */
    public function generateUuid(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }

    /**
     * Start transaction
     */
    public function beginTransaction(): void
    {
        $this->inTransaction = true;
        $this->transactionBackups = [];
    }

    /**
     * Commit transaction
     */
    public function commit(): void
    {
        $this->inTransaction = false;
        $this->transactionBackups = [];
    }

    /**
     * Rollback transaction
     */
    public function rollback(): void
    {
        if ($this->inTransaction) {
            foreach ($this->transactionBackups as $col => $data) {
                $this->writeRaw($col, $data);
            }
        }
        $this->inTransaction = false;
        $this->transactionBackups = [];
    }
}
