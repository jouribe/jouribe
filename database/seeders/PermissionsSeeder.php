<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $tableNames = ['users', 'posts', 'tags', 'categories', 'addresses', 'profiles', 'roles', 'permissions', 'comments'];
        $permissions = ['view', 'create', 'update', 'delete', 'restore', 'destroy', 'manage'];

        foreach ($tableNames as $tableName) {
            foreach ($permissions as $permission) {
                Permission::create(['name' => "$permission $tableName"]);
            }
        }
    }
}
