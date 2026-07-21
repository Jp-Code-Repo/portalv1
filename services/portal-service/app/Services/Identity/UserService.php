<?php

namespace App\Services\Identity;

use App\Data\Identity\CreateUserData;
use App\Models\Person;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;

class UserService
{
    public function createUser(CreateUserData $data): User
    {
        $start = microtime(true);

        Log::info('User creation started.');

        try {

            $user = DB::transaction(function () use ($data, $start) {

                Log::info('Creating Person...', [
                    'elapsed_ms' => round((microtime(true) - $start) * 1000, 2),
                ]);

                $person = Person::create([
                    'first_name'  => $data->firstName,
                    'middle_name' => $data->middleName,
                    'last_name'   => $data->lastName,
                    'suffix'      => $data->suffix,
                ]);

                Log::info('Person created.', [
                    'elapsed_ms' => round((microtime(true) - $start) * 1000, 2),
                    'person_id'  => $person->id,
                ]);

                Log::info('Creating User...', [
                    'elapsed_ms' => round((microtime(true) - $start) * 1000, 2),
                ]);

                $user = User::create([
                    'person_id' => $person->id,
                    'email'     => $data->email,
                    'password'  => Hash::make($data->password),
                    'status'    => 'pending',
                ]);

                Log::info('User created.', [
                    'elapsed_ms' => round((microtime(true) - $start) * 1000, 2),
                    'user_id'    => $user->id,
                ]);

                return $user;
            });

            Log::info('User creation completed.', [
                'total_elapsed_ms' => round((microtime(true) - $start) * 1000, 2),
            ]);

            return $user;

        } catch (Throwable $e) {

            Log::error('User creation failed.', [
                'message'          => $e->getMessage(),
                'file'             => $e->getFile(),
                'line'             => $e->getLine(),
                'total_elapsed_ms' => round((microtime(true) - $start) * 1000, 2),
            ]);

            throw $e;
        }
    }
}