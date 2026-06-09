<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $departments = Department::factory()->createMany([
            ['name' => 'Engineering'],
            ['name' => 'Human Resources'],
            ['name' => 'Marketing'],
            ['name' => 'Finance'],
        ]);

        Employee::factory()->create([
            'department_id' => $departments[0]->id,
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'position' => 'Software Engineer',
            'salary' => 85000.00,
        ]);

        Employee::factory()->create([
            'department_id' => $departments[1]->id,
            'name' => 'John Smith',
            'email' => 'john.smith@example.com',
            'position' => 'HR Manager',
            'salary' => 72000.00,
        ]);

        Employee::factory()->count(5)->create();
    }
}
