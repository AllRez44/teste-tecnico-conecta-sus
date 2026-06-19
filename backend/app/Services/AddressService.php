<?php

namespace App\Services;

use App\Repositories\AddressRepository;
use Illuminate\Validation\ValidationException;

class AddressService
{
    private AddressRepository $addressRepository;

    public function __construct(AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function all()
    {
        return $this->addressRepository->all();
    }

    public function find(int $id)
    {
        return $this->addressRepository->find($id);
    }

    public function store(array $data)
    {
        return $this->addressRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->addressRepository->update($data, $id);
    }

    public function delete(int $id)
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
