<?php

namespace App\Repositories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AddressRepository implements RepositoryInterface
{
    public function all(): Collection
    {
        return Address::all();
    }

    public function paginate(int $perPage = 10, ?string $search = null): LengthAwarePaginator
    {
        $query = Address::query();
        if ($search) {
            $query->where('street', 'like', "%{$search}%")
                ->orWhere('zip_code', 'like', "%{$search}%")
                ->orWhere('neighborhood', 'like', "%{$search}%")
                ->orWhere('city', 'like', "%{$search}%")
                ->orWhere('state', 'like', "%{$search}%");
        }
        return $query->paginate($perPage);
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
