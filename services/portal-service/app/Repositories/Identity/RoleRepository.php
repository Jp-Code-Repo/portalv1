<?php

namespace App\Repositories\Identity;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository
{
    public function create(array $data): Role
    {
        return Role::create($data);
    }

    public function findById(int $id): ?Role
    {
        return Role::find($id);
    }

    public function findAll(): Collection
    {
        return Role::orderBy('name')->get();
    }

    public function update(Role $role, array $data): Role
    {
        $role->update($data);

        return $role->refresh();
    }

    public function delete(Role $role): void
    {
        $role->delete();
    }

    public function restore(Role $role): Role
    {
        $role->restore();

        return $role->refresh();
    }

    public function findByIdWithTrashed(int $id): ?Role
    {
        return Role::withTrashed()->find($id);
    }
}