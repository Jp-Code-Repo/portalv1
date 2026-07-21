<?php

namespace App\Http\Controllers\Api\Identity;

use App\Http\Controllers\Controller;
use App\Data\Identity\CreateUserData;
use App\Http\Requests\StoreUserRequest;
use App\Services\Identity\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {
    }

    public function store(StoreUserRequest $request)
    {
        $start = microtime(true);

        $user = $this->userService->createUser($request->toDto());

        \Log::info('Controller elapsed', [
            'elapsed_ms' => round((microtime(true) - $start) * 1000, 2),
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'data' => $user,
        ], 201);
    }
}
