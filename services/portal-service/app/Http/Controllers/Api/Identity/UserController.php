<?php

namespace App\Http\Controllers\Api\Identity;

use App\Http\Controllers\Controller;
use App\Data\Identity\CreateUserData;
use App\Http\Requests\StoreUserRequest;
use App\Services\Identity\UserService;
use Illuminate\Http\JsonResponse;
use App\Data\Identity\UpdateUserData;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {
    }

    public function store(StoreUserRequest $request)
    {
        $start = microtime(true);

        $user = $this->userService->createUser(
            CreateUserData::fromRequest($request)
        );

        \Log::info('Controller elapsed', [
            'elapsed_ms' => round((microtime(true) - $start) * 1000, 2),
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'data' => $user,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $user = $this->userService->findUserById($id);

        return response()->json([
            'data' => $user,
        ]);
    }

    public function index(): JsonResponse
    {
        $users = $this->userService->findAllUsers();

        return response()->json([
            'data' => $users,
        ]);
    }

    public function update(UpdateUserRequest $request, string $id): JsonResponse
    {
        $user = $this->userService->updateUser(
            $id,
            UpdateUserData::from($request->validated())
        );

        return response()->json([
            'data' => $user,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->userService->deleteUser($id);

        return response()->json([
            'message' => 'User deleted successfully.',
        ]);
    }

    public function restore(string $id): JsonResponse
    {
        $user = $this->userService->restoreUser($id);

        return response()->json([
            'message' => 'User restored successfully.',
            'data' => $user,
        ]);
    }


}
