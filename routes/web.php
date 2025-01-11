<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/mfa/{id}', function () {
    return view('emails.mfa_token');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/forgot-password', function () {
    return view('auth.forgot-password'); 
});

Route::get('/reset-password', function () {
    return view('password.reset');
})->name('password.reset');

Route::middleware(['web'])->group(function () {
    // These routes require authentication
    Route::get('/customers/create', function () {
        return view('customers.customer-create');
    });

    Route::get('/customers', function () {
        return view('customers.customer-list');
    });

    Route::get('/customers/{id}/edit', function () {
        return view('customers.customer-edit');
    });
});


