<?php
declare(strict_types=1);

namespace App\Storage;

/**
 * Enterprise Query Builder for JSON Collections
 */
class QueryBuilder
{
    private JsonStorageEngine $engine;
    private string $collection;
    private array $conditions = [];
    private ?string $orderKey = null;
    private string $orderDirection = 'ASC';
    private ?int $limitCount = null;
    private int $offsetCount = 0;

    public function __construct(string $collection, ?JsonStorageEngine $engine = null)
    {
        $this->collection = $collection;
        $this->engine = $engine ?? JsonStorageEngine::getInstance();
    }

    public static function table(string $collection): self
    {
        return new self($collection);
    }

    /**
     * Add WHERE condition
     */
    public function where(string $key, mixed $operator, mixed $value = null): self
    {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }

        $this->conditions[] = [
            'type' => 'basic',
            'key' => $key,
            'operator' => strtoupper($operator),
            'value' => $value,
        ];
        return $this;
    }

    /**
     * Add WHERE IN condition
     */
    public function whereIn(string $key, array $values): self
    {
        $this->conditions[] = [
            'type' => 'in',
            'key' => $key,
            'values' => $values,
        ];
        return $this;
    }

    /**
     * Add search LIKE condition
     */
    public function whereLike(string $key, string $search): self
    {
        $this->conditions[] = [
            'type' => 'like',
            'key' => $key,
            'search' => strtolower($search),
        ];
        return $this;
    }

    /**
     * Set sorting order
     */
    public function orderBy(string $key, string $direction = 'ASC'): self
    {
        $this->orderKey = $key;
        $this->orderDirection = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
        return $this;
    }

    /**
     * Set limit and offset
     */
    public function limit(int $limit, int $offset = 0): self
    {
        $this->limitCount = $limit;
        $this->offsetCount = $offset;
        return $this;
    }

    /**
     * Execute query and get all matching records
     */
    public function get(): array
    {
        $data = $this->engine->read($this->collection);

        // Apply filters
        $filtered = array_filter($data, function ($item) {
            foreach ($this->conditions as $cond) {
                $val = $item[$cond['key']] ?? null;

                if ($cond['type'] === 'basic') {
                    $op = $cond['operator'];
                    $target = $cond['value'];

                    switch ($op) {
                        case '=':
                        case '==':
                            if ($val != $target) return false;
                            break;
                        case '===':
                            if ($val !== $target) return false;
                            break;
                        case '!=':
                        case '<>':
                            if ($val == $target) return false;
                            break;
                        case '>':
                            if (!($val > $target)) return false;
                            break;
                        case '>=':
                            if (!($val >= $target)) return false;
                            break;
                        case '<':
                            if (!($val < $target)) return false;
                            break;
                        case '<=':
                            if (!($val <= $target)) return false;
                            break;
                    }
                } elseif ($cond['type'] === 'in') {
                    if (!in_array($val, $cond['values'], true)) {
                        return false;
                    }
                } elseif ($cond['type'] === 'like') {
                    if (empty($val) || !str_contains(strtolower((string)$val), $cond['search'])) {
                        return false;
                    }
                }
            }
            return true;
        });

        $filtered = array_values($filtered);

        // Apply sorting
        if ($this->orderKey !== null) {
            usort($filtered, function ($a, $b) {
                $valA = $a[$this->orderKey] ?? null;
                $valB = $b[$this->orderKey] ?? null;

                if ($valA === $valB) return 0;

                if ($this->orderDirection === 'ASC') {
                    return ($valA < $valB) ? -1 : 1;
                } else {
                    return ($valA > $valB) ? -1 : 1;
                }
            });
        }

        // Apply offset and limit
        if ($this->limitCount !== null) {
            $filtered = array_slice($filtered, $this->offsetCount, $this->limitCount);
        }

        return $filtered;
    }

    /**
     * Get first record or null
     */
    public function first(): ?array
    {
        $this->limitCount = 1;
        $this->offsetCount = 0;
        $results = $this->get();
        return $results[0] ?? null;
    }

    /**
     * Count matching records
     */
    public function count(): int
    {
        $currentLimit = $this->limitCount;
        $currentOffset = $this->offsetCount;

        $this->limitCount = null;
        $this->offsetCount = 0;

        $count = count($this->get());

        $this->limitCount = $currentLimit;
        $this->offsetCount = $currentOffset;

        return $count;
    }

    /**
     * Paginate query results
     */
    public function paginate(int $page = 1, int $perPage = 15): array
    {
        $page = max(1, $page);
        $total = $this->count();
        $lastPage = (int) ceil($total / $perPage);
        if ($lastPage < 1) $lastPage = 1;

        $offset = ($page - 1) * $perPage;
        $this->limit($perPage, $offset);

        $items = $this->get();

        return [
            'data' => $items,
            'total' => $total,
            'current_page' => $page,
            'per_page' => $perPage,
            'last_page' => $lastPage,
            'from' => $total === 0 ? 0 : $offset + 1,
            'to' => min($offset + $perPage, $total),
        ];
    }
}
