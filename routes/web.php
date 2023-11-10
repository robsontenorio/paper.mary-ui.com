<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Login
Volt::route('/login', 'login')->name('login');

//Logout
Route::get('/logout', function () {
    auth()->logout();

    return redirect('/');
});

Volt::route('/', 'index');

Route::middleware('auth')->group(function () {
    Volt::route('/posts/create', 'posts.edit');
    Volt::route('/posts/{post}/edit', 'posts.edit');
    Volt::route('/profile', 'profile');
});

Volt::route('/posts/{post}', 'posts.show');
