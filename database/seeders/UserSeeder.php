<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Jorge O. Uribe',
            'email' => 'jorge@jouribe.dev',
            'password' => bcrypt('password'),
        ]);

        $admin = Role::create(['name' => 'Super Admin']);

        $user->assignRole($admin);
    }
}
