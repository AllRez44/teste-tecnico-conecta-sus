<?php

namespace App\Services;

use App\Repositories\AddressRepository;
use App\Repositories\PatientRepository;

class DashboardService
{

    public function __construct(
      private AddressRepository $addressRepository,
      private PatientRepository $patientRepository,
    ) {
    }

    public function getSummary(): array
    {
        return [
            'total_addresses' => $this->addressRepository->all()->count(),
            'total_patients' => $this->patientRepository->all()->count(),
        ];
    }
}
