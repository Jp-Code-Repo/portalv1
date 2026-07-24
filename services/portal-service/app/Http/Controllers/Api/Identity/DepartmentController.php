<?php

namespace App\Http\Controllers\Api\Identity;

use App\Data\Identity\StoreDepartmentData;
use App\Data\Identity\UpdateDepartmentData;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Services\Identity\DepartmentService;
use Illuminate\Http\JsonResponse;

class DepartmentController extends Controller
{
    public function __construct(
        private readonly DepartmentService $departmentService,
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'data' => $this->departmentService->findAll(),
        ]);
    }

    public function store(StoreDepartmentRequest $request): JsonResponse
    {
        $department = $this->departmentService->create(
            StoreDepartmentData::from($request->validated())
        );

        return response()->json([
            'message' => 'Department created successfully.',
            'data' => $department,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json([
            'data' => $this->departmentService->findById($id),
        ]);
    }

    public function update(UpdateDepartmentRequest $request, int $id): JsonResponse
    {
        $department = $this->departmentService->update(
            $id,
            UpdateDepartmentData::from($request->validated())
        );

        return response()->json([
            'message' => 'Department updated successfully.',
            'data' => $department,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->departmentService->delete($id);

        return response()->json([
            'message' => 'Department deleted successfully.',
        ]);
    }

    public function restore(int $id): JsonResponse
    {
        $department = $this->departmentService->restore($id);

        return response()->json([
            'message' => 'Department restored successfully.',
            'data' => $department,
        ]);
    }
}