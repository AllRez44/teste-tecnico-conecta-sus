<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Services\PatientService;
use Illuminate\Http\JsonResponse;

class PatientController extends Controller
{
    public function __construct(
        private PatientService $patientService,
    ) {
    }

    public function index(): JsonResponse
    {
        $patients = $this->patientService->all();
        return response()->json($patients);
    }

    public function store(StorePatientRequest $request): JsonResponse
    {
        $patient = $this->patientService->store($request->validated());
        return response()->json($patient, 201);
    }

    public function show(int $id): JsonResponse
    {
        $patient = $this->patientService->find($id);
        if (!$patient) {
            return response()->json(['message' => 'Paciente não encontrado'], 404);
        }
        return response()->json($patient);
    }

    public function update(UpdatePatientRequest $request, int $id): JsonResponse
    {
        $this->patientService->update($id, $request->validated());
        return response()->json($this->patientService->find($id));
    }

    public function destroy(int $id): JsonResponse
    {
        $this->patientService->delete($id);
        return response()->json(null, 204);
    }
}
