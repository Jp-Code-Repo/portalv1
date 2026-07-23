<?php

namespace App\Services\Identity;

use App\Data\Identity\CreateUserData;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User;
use App\Repositories\Identity\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use App\Data\Identity\UpdateUserData;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function createUser(CreateUserData $data): User
    {
        $start = microtime(true);

        Log::info('User creation started.');

        try {
            $user = DB::transaction(function () use ($data) {
                return $this->userRepository->create($data);
            });

            Log::info('User creation completed.', [
                'total_elapsed_ms' => round((microtime(true) - $start) * 1000, 2),
                'user_id'          => $user->id,
            ]);

            return $user;
        } catch (Throwable $e) {
            Log::error('User creation failed.', [
                'message'    => $e->getMessage(),
                'elapsed_ms' => round((microtime(true) - $start) * 1000, 2),
            ]);

            throw $e;
        }
    }

    public function findUserById(string $id): User
    {
        Log::info('User retrieval started.', [
            'user_id' => $id,
        ]);

        $user = $this->userRepository->findById($id);

        if (! $user) {
            throw new ModelNotFoundException('User not found.');
        }

        Log::info('User retrieval completed.', [
            'user_id' => $id,
        ]);

        return $user;
    }

    public function findAllUsers(): Collection
    {
        Log::info('User listing started.');

        $users = $this->userRepository->findAll();

        Log::info('User listing completed.', [
            'count' => $users->count(),
        ]);

        return $users;
    }

    public function updateUser(string $id, UpdateUserData $data): User
    {
        Log::info('User update started.', [
            'user_id' => $id,
        ]);

        $user = DB::transaction(function () use ($id, $data) {
            return $this->userRepository->update($id, $data);
        });

        Log::info('User update completed.', [
            'user_id' => $user->id,
        ]);

        return $user;
    }
}