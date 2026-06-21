<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Services\PatientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{
    public function __construct(
        private PatientService $patientService,
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 1510);
        $search = $request->get('search');
        
        $patients = $this->patientService->paginate((int) $perPage, $search);
        return response()->json($patients);
    }

    public function store(StorePatientRequest $request): JsonResponse
    {
        $patient = $this->patientService->store($request->validated());
        Log::info('Patient created successfully', ['patient_id' => $patient->id ?? null, 'data' => $request->validated()]);
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
        Log::info('Patient updated successfully', ['patient_id' => $id, 'data' => $request->validated()]);
        return response()->json($this->patientService->find($id));
    }

    public function destroy(int $id): JsonResponse
    {
        $this->patientService->delete($id);
        Log::info('Patient deleted successfully', ['patient_id' => $id]);
        return response()->json(null, 204);
    }
}
