<?php

use App\Controllers\WorkerController;
use Core\Routing\Router;
use App\Controllers\AuthController;

Router::get('registration', AuthController::class, 'renderRegistration');
Router::post('registration', AuthController::class, 'registration');
Router::get('login', AuthController::class, 'renderLogin');
Router::post('login', AuthController::class, 'login');
Router::post('logout', AuthController::class, 'logout');

Router::get('api/workers/([0-9]+)', WorkerController::class, 'get')->withAuth();
Router::put('api/workers/([0-9]+)', WorkerController::class, 'update')->withAuth();
Router::delete('api/workers/([0-9]+)', WorkerController::class, 'delete')->withAuth();
Router::post('api/workers', WorkerController::class, 'create')->withAuth();

Router::get('workers', WorkerController::class, 'index')->withAuth();
