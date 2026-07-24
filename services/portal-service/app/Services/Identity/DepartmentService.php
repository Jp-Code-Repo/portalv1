<?php

namespace App\Services\Identity;

use App\Data\Identity\StoreDepartmentData;
use App\Data\Identity\UpdateDepartmentData;
use App\Models\Department;
use App\Repositories\Identity\DepartmentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class DepartmentService
{
    public function __construct(
        private readonly DepartmentRepository $departmentRepository,
    ) {
    }

    public function create(StoreDepartmentData $data): Department
    {
        return DB::transaction(function () use ($data) {
            return $this->departmentRepository->create([
                'code' => $data->code,
                'name' => $data->name,
                'description' => $data->description,
                'is_active' => $data->isActive,
            ]);
        });
    }

    public function findById(int $id): Department
    {
        return $this->departmentRepository->findById($id)
            ?? throw new ModelNotFoundException('Department not found.');
    }

    public function findAll(): Collection
    {
        return $this->departmentRepository->findAll();
    }

    public function update(int $id, UpdateDepartmentData $data): Department
    {
        return DB::transaction(function () use ($id, $data) {
            $department = $this->findById($id);

            return $this->departmentRepository->update($department, [
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
            $department = $this->findById($id);

            $this->departmentRepository->delete($department);
        });
    }

    public function restore(int $id): Department
    {
        return DB::transaction(function () use ($id) {
            $department = $this->departmentRepository->findByIdWithTrashed($id);

            if (! $department) {
                throw new ModelNotFoundException('Department not found.');
            }

            return $this->departmentRepository->restore($department);
        });
    }
}