<?php

use App\Models\Department;
use App\Models\Employee;

it('displays employees with joined department names', function () {
    loginAsUser();

    $department = Department::factory()->create(['name' => 'Engineering']);
    Employee::factory()->create([
        'department_id' => $department->id,
        'name' => 'Alice Johnson',
        'email' => 'alice@example.com',
    ]);

    $response = $this->get(route('employees.index'));

    $response->assertSuccessful();
    $response->assertSee('Alice Johnson');
    $response->assertSee('Engineering');
});

it('creates an employee', function () {
    loginAsUser();

    $department = Department::factory()->create();

    $response = $this->post(route('employees.store'), [
        'department_id' => $department->id,
        'name' => 'Bob Builder',
        'email' => 'bob@example.com',
        'position' => 'Developer',
        'salary' => 75000,
    ]);

    $response->assertRedirect(route('employees.index'));
    $this->assertDatabaseHas('employees', [
        'email' => 'bob@example.com',
        'department_id' => $department->id,
    ]);
});

it('updates an employee', function () {
    loginAsUser();

    $department = Department::factory()->create();
    $employee = Employee::factory()->create([
        'department_id' => $department->id,
        'name' => 'Old Name',
    ]);

    $response = $this->put(route('employees.update', $employee), [
        'department_id' => $department->id,
        'name' => 'New Name',
        'email' => $employee->email,
        'position' => $employee->position,
        'salary' => $employee->salary,
    ]);

    $response->assertRedirect(route('employees.index'));
    $this->assertDatabaseHas('employees', [
        'id' => $employee->id,
        'name' => 'New Name',
    ]);
});

it('deletes an employee via ajax and returns json', function () {
    loginAsUser();

    $employee = Employee::factory()->create();

    $response = $this->deleteJson(route('employees.destroy', $employee));

    $response->assertSuccessful();
    $response->assertJson(['success' => true]);
    $this->assertDatabaseMissing('employees', ['id' => $employee->id]);
});
