<?php

use Livewire\Volt\Volt;

// Login
Volt::route('/login', 'login')->name('login');

//Logout
Route::get('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
});

Volt::route('/', 'posts.index');

Route::middleware('auth')->group(function () {
    Volt::route('/posts/create', 'posts.create');
    Volt::route('/posts/{post}/edit', 'posts.edit');
    Volt::route('/profile', 'profile');
});

Volt::route('/posts/{post}', 'posts.show');
