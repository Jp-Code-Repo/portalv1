<?php

namespace App\Repositories\Identity;

use App\Data\Identity\CreateUserData;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Person;
use App\Models\User;
use App\Data\Identity\UpdateUserData;

class UserRepository
{
    public function create(CreateUserData $data): User
    {
        $person = Person::create([
            'first_name'  => $data->firstName,
            'middle_name' => $data->middleName,
            'last_name'   => $data->lastName,
            'suffix'      => $data->suffix,
        ]);

        return User::create([
            'person_id' => $person->id,
            'email'     => $data->email,
            'password'  => bcrypt($data->password),
            'status'    => 'pending',
        ]);
    }

    public function findById(string $id): ?User
    {
        return User::with('person')->find($id);
    }

    public function findAll(): Collection
    {
        return User::with('person')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function update(string $id, UpdateUserData $data): User
    {
        $user = User::with('person')->findOrFail($id);

        $user->update([
            'email' => $data->email,
            'username' => $data->username,
            'is_active' => $data->is_active,
        ]);

        $user->person->update([
            'first_name'   => $data->first_name,
            'middle_name'  => $data->middle_name,
            'last_name'    => $data->last_name,
            'suffix'       => $data->suffix,
            'birth_date'   => $data->birth_date,
            'sex'          => $data->sex,
            'civil_status' => $data->civil_status,
            'nationality_id' => $data->nationality_id,
        ]);

        return $user->fresh()->load('person');
    }
}