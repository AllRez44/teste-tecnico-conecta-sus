<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Services\AddressService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct(
      private AddressService $addressService,
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');
        
        $addresses = $this->addressService->paginate((int) $perPage, $search);
        return response()->json($addresses);
    }

    public function store(StoreAddressRequest $request): JsonResponse
    {
        $address = $this->addressService->store($request->validated());
        return response()->json($address, 201);
    }

    public function show(int $id): JsonResponse
    {
        $address = $this->addressService->find($id);
        if (!$address) {
            return response()->json(['message' => 'Endereço não encontrado'], 404);
        }
        return response()->json($address);
    }

    public function update(UpdateAddressRequest $request, int $id): JsonResponse
    {
        $this->addressService->update($id, $request->validated());
        return response()->json($this->addressService->find($id));
    }

    public function destroy(int $id): JsonResponse
    {
        $this->addressService->delete($id);
        return response()->json(null, 204);
    }
}
