<?php

namespace App\Repositories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PatientRepository implements RepositoryInterface
{
    public function all(): Collection
    {
        return Patient::all();
    }

    /**
     * @param array $data
     * @return Patient
     */
    public function create(array $data): ?Model
    {
        $patient = new Patient();
        $patient->fill($data);
        $patient->save();
        return $patient;
    }

    public function update(array $data, int $id): int
    {
        $patient = Patient::findOrFail($id);
        return $patient->update($data);
    }

    public function delete(int $id): bool
    {
        $patient = Patient::findOrFail($id);
        return $patient->delete();
    }

    /**
     * @param int $id
     * @return Patient|null
     */
    public function find(int $id): ?Model
    {
        return Patient::find($id);
    }
}
