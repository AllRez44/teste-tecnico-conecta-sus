<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function all(): \Illuminate\Database\Eloquent\Collection;

    public function create(array $data): ?Model;

    public function update(array $data, int $id): int;

    public function delete(int $id): bool;

    public function find(int $id): ?Model;
}
