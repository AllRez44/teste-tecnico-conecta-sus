<?php

namespace App\Services;

use App\Repositories\PatientRepository;

class PatientService
{
    private PatientRepository $patientRepository;

    public function __construct(PatientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    public function all()
    {
        return $this->patientRepository->all();
    }

    public function find(int $id)
    {
        return $this->patientRepository->find($id);
    }

    public function store(array $data)
    {
        return $this->patientRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->patientRepository->update($data, $id);
    }

    public function delete(int $id)
    {
        return $this->patientRepository->delete($id);
    }
}
