<?php

namespace App\Services\Identity;

use App\Data\Identity\StoreRoleData;
use App\Data\Identity\UpdateRoleData;
use App\Models\Role;
use App\Repositories\Identity\RoleRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class RoleService
{
    public function __construct(
        private readonly RoleRepository $roleRepository,
    ) {
    }

    public function create(StoreRoleData $data): Role
    {
        return DB::transaction(function () use ($data) {
            return $this->roleRepository->create([
                'code' => $data->code,
                'name' => $data->name,
                'description' => $data->description,
                'is_active' => $data->isActive,
            ]);
        });
    }

    public function findById(int $id): Role
    {
        return $this->roleRepository->findById($id)
            ?? throw new ModelNotFoundException('Role not found.');
    }

    public function findAll(): Collection
    {
        return $this->roleRepository->findAll();
    }

    public function update(int $id, UpdateRoleData $data): Role
    {
        return DB::transaction(function () use ($id, $data) {
            $role = $this->findById($id);

            return $this->roleRepository->update($role, [
                'code' => $data->code,
                'name' => $data->name,
                'description' => $data->description,
                'is_active' => $data->isActive,
            ]);
        });
    }

    public function delete(int $id): void
    {
        DB::transaction(function () use ($id) {
            $role = $this->findById($id);

            $this->roleRepository->delete($role);
        });
    }

    public function restore(int $id): Role
    {
        return DB::transaction(function () use ($id) {
            $role = $this->roleRepository->findByIdWithTrashed($id);

            if (! $role) {
                throw new ModelNotFoundException('Role not found.');
            }

            return $this->roleRepository->restore($role);
        });
    }
}