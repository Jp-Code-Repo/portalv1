<?php

namespace App\Repositories\Identity;

use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;

class DepartmentRepository
{
    public function create(array $data): Department
    {
        return Department::create($data);
    }

    public function findById(int $id): ?Department
    {
        return Department::find($id);
    }

    public function findAll(): Collection
    {
        return Department::orderBy('name')->get();
    }

    public function update(Department $department, array $data): Department
    {
        $department->update($data);

        return $department->refresh();
    }

    public function delete(Department $department): void
    {
        $department->delete();
    }

    public function restore(Department $department): Department
    {
        $department->restore();

        return $department->refresh();
    }

    public function findByIdWithTrashed(int $id): ?Department
    {
        return Department::withTrashed()->find($id);
    }
}