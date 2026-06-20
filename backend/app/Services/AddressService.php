<?php

namespace App\Services;

use App\Models\Address;
use App\Repositories\AddressRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class AddressService
{
    private AddressRepository $addressRepository;

    public function __construct(AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function all(): Collection
    {
        return $this->addressRepository->all();
    }

    public function find(int $id): ?Address
    {
        return $this->addressRepository->find($id);
    }

    public function store(array $data): ?Address
    {
        return $this->addressRepository->create($data);
    }

    public function update(int $id, array $data): int
    {
        return $this->addressRepository->update($data, $id);
    }

    public function delete(int $id): bool
    {
        $address = $this->addressRepository->find($id);

        if ($address && $address->patients()->count() > 0) {
            throw ValidationException::withMessages([
                'address' => 'Endereço com pacientes vinculados não pode ser excluído.',
            ]);
        }

        return $this->addressRepository->delete($id);
    }
}
