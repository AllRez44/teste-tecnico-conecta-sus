<?php

namespace App\Services;

use App\Models\Patient;
use App\Repositories\PatientRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PatientService
{
    public function __construct(
        private PatientRepository $patientRepository,
    ) {
    }

    public function all(): Collection
    {
        return $this->patientRepository->all();
    }

    public function paginate(int $perPage = 10, ?string $search = null, ?string $orderBy = null, ?string $orderDir = 'asc'): LengthAwarePaginator
    {
        return $this->patientRepository->paginate($perPage, $search, $orderBy, $orderDir);
    }

    public function find(int $id): ?Patient
    {
        return $this->patientRepository->find($id);
    }

    public function store(array $data): ?Patient
    {
        return $this->patientRepository->create($data);
    }

    public function update(int $id, array $data): int
    {
        return $this->patientRepository->update($data, $id);
    }

    public function delete(int $id): bool
    {
        return $this->patientRepository->delete($id);
    }
}
