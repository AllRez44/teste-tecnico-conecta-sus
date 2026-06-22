<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function all(): Collection;

    public function paginate(int $perPage = 10, ?string $search = null, ?string $orderBy = null, ?string $orderDir = 'asc'): LengthAwarePaginator;

    public function create(array $data): ?Model;

    public function update(array $data, int $id): int;

    public function delete(int $id): bool;

    public function find(int $id): ?Model;
}
