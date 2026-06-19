<?php

namespace App\Repositories;

use App\Models\Address;
use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class AddressRepository implements RepositoryInterface
{
    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return Address::all();
    }

    /**
     * @param array $data
     * @return Address
     */
    public function create(array $data): ?Model
    {
        $address = new Address();
        $address->fill($data);
        $address->save();
        return $address;
    }

    public function update(array $data, int $id): int
    {
        $address = Address::findOrFail($id);
        return $address->update($data);
    }

    public function delete(int $id): bool
    {
        $address = Address::findOrFail($id);
        return $address->delete();
    }

    /**
     * @param int $id
     * @return Address|null
     */
    public function find(int $id): ?Model
    {
        return Address::find($id);
    }
}
