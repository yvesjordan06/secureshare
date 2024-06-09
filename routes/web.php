<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/secrets/create');
});

Route::get('/healtcheck', function () {
    return 'OK';
});


Route::resource('secrets', App\Http\Controllers\SecretController::class)
    ->only('create', 'store')
    ->name('create', 'secret.create')
    -> name('store', 'secret.store');

Route::get('/secrets/{id}', App\Http\Controllers\SecretController::class . '@view')
    -> name('secret.view');

    Route::post('/secrets/{id}', App\Http\Controllers\SecretController::class . '@unlock')
    -> name('secret.unlock');
