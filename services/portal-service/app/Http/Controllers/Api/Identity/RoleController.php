<?php

namespace App\Http\Controllers\Api\Identity;

use App\Data\Identity\StoreRoleData;
use App\Data\Identity\UpdateRoleData;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Services\Identity\RoleService;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    public function __construct(
        private readonly RoleService $roleService,
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'data' => $this->roleService->findAll(),
        ]);
    }

    public function store(StoreRoleRequest $request): JsonResponse
    {
        $role = $this->roleService->create(
            StoreRoleData::from($request->validated())
        );

        return response()->json([
            'message' => 'Role created successfully.',
            'data' => $role,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json([
            'data' => $this->roleService->findById($id),
        ]);
    }

    public function update(UpdateRoleRequest $request, int $id): JsonResponse
    {
        $role = $this->roleService->update(
            $id,
            UpdateRoleData::from($request->validated())
        );

        return response()->json([
            'message' => 'Role updated successfully.',
            'data' => $role,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->roleService->delete($id);

        return response()->json([
            'message' => 'Role deleted successfully.',
        ]);
    }

    public function restore(int $id): JsonResponse
    {
        $role = $this->roleService->restore($id);

        return response()->json([
            'message' => 'Role restored successfully.',
            'data' => $role,
        ]);
    }
}