<?php

namespace App\Models\Employees\Repositories\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Models\Employees\Employee;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

interface EmployeeRepositoryInterface extends BaseRepositoryInterface
{
    public function listEmployees(): Collection;

    public function createEmployee(array $params) : Employee;

    public function findEmployeeById(int $id) : Employee;

    public function updateEmployee(array $params): bool;

    public function syncRoles(array $roleIds);

    public function listRoles() : Collection;

    public function hasRole(string $roleName) : bool;

    public function isAuthUser(Employee $employee): bool;

    public function deleteEmployee() : bool;

    public function saveCoverImage(UploadedFile $file) : string;

    public function deleteFile(string $get_data);
}
