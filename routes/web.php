<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*
 * TODO
 *
 * Jump to container: docker exec -it <container_name> <format>
 *
 * 1. Up containers (docker compose up -d --build)
 * 2. Create Model and migration (php artisan make:model Student -m) in php container
 * 3. Create Factory (php artisan make:Factory StudentFactory) in php container
 * 4. Run the Factory in the tinker (php artisan ti)
 * 5. Show Students table
 *
 */
