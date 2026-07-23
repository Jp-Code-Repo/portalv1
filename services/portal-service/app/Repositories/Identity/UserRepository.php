<?php

namespace App\Repositories\Identity;

use App\Data\Identity\CreateUserData;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Person;
use App\Models\User;
use App\Data\Identity\UpdateUserData;
use Illuminate\Support\Facades\Hash;

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
    {   // nullable
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
        $user = $this->getById($id);

        $user->update([
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);

        $user->person->update([
            'first_name'  => $data->firstName,
            'middle_name' => $data->middleName,
            'last_name'   => $data->lastName,
            'suffix'      => $data->suffix,
        ]);

        return $user->fresh()->load('person');
    }

    public function getById(string $id): User
    {   // required (findOrFail)
        return User::with('person')->findOrFail($id);
    }

    public function delete(User $user): void
    {
        $user->delete();
    }

    public function getByIdWithTrashed(string $id): User
    {
        return User::withTrashed()
            ->with('person')
            ->findOrFail($id);
    }

}