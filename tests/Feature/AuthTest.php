<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('registers a user with hashed password and session', function () {
    $response = $this->post('/register', [
        'name' => 'New User',
        'email' => 'newuser@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect(route('employees.index'));

    $user = User::query()->where('email', 'newuser@example.com')->first();

    expect($user)->not->toBeNull();
    expect(Hash::check('password123', $user->password))->toBeTrue();
    expect(session('user_id'))->toBe($user->id);
});

it('logs in with valid credentials', function () {
    $user = User::factory()->create([
        'email' => 'login@example.com',
        'password' => 'password123',
    ]);

    $response = $this->post('/login', [
        'email' => 'login@example.com',
        'password' => 'password123',
    ]);

    $response->assertRedirect(route('employees.index'));
    expect(session('user_id'))->toBe($user->id);
});

it('rejects invalid login credentials', function () {
    User::factory()->create([
        'email' => 'login@example.com',
        'password' => 'password123',
    ]);

    $response = $this->post('/login', [
        'email' => 'login@example.com',
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors('email');
    expect(session('user_id'))->toBeNull();
});

it('logs out and clears the session', function () {
    $user = loginAsUser();

    $response = $this->post('/logout');

    $response->assertRedirect(route('login'));
    expect(session('user_id'))->toBeNull();
});

it('redirects guests away from protected routes', function () {
    $response = $this->get(route('employees.index'));

    $response->assertRedirect(route('login'));
});

it('redirects authenticated users away from login page', function () {
    loginAsUser();

    $response = $this->get(route('login'));

    $response->assertRedirect(route('employees.index'));
});
