<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Storage\JsonStorageEngine;
use App\Storage\QueryBuilder;

/**
 * Base Repository Abstraction
 */
abstract class BaseRepository
{
    protected string $collection;
    protected JsonStorageEngine $engine;

    public function __construct(string $collection, ?JsonStorageEngine $engine = null)
    {
        $this->collection = $collection;
        $this->engine = $engine ?? JsonStorageEngine::getInstance();
    }

    public function query(): QueryBuilder
    {
        return new QueryBuilder($this->collection, $this->engine);
    }

    public function all(): array
    {
        return $this->query()->orderBy('created_at', 'DESC')->get();
    }

    public function find(string $id): ?array
    {
        return $this->engine->find($this->collection, $id);
    }

    public function create(array $data): array
    {
        return $this->engine->insert($this->collection, $data);
    }

    public function update(string $id, array $data): ?array
    {
        return $this->engine->update($this->collection, $id, $data);
    }

    public function delete(string $id): bool
    {
        return $this->engine->delete($this->collection, $id);
    }

    public function count(): int
    {
        return $this->query()->count();
    }
}
