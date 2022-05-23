<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controller\APIController;
use Controller\AdminController;
use Controller\LoginController;
use Controller\AppointmentController;
use Controller\ServiceController;

$router = new Router();

// Login
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);

// Logout
$router->get('/logout', [LoginController::class, 'logout']);

// Reset password
$router->get('/forgot', [LoginController::class, 'forgot']);
$router->post('/forgot', [LoginController::class, 'forgot']);
$router->get('/reset', [LoginController::class, 'reset']);
$router->post('/reset', [LoginController::class, 'reset']);

// Creating an account
$router->get('/create-account', [LoginController::class, 'create']);
$router->post('/create-account', [LoginController::class, 'create']);

// Confirming account
$router->get('/confirm-account', [LoginController::class, 'confirm']);
$router->get('/message', [LoginController::class, 'message']);

// Private area
$router->get('/appointment', [AppointmentController::class, 'index']);
$router->get('/admin', [AdminController::class, 'index']);

// Appointment API
$router->get('/api/services', [APIController::class, 'index']);
$router->post('/api/appointments', [APIController::class, 'save']);
$router->post('/api/delete', [APIController::class, 'delete']);

// Service CRUD
$router->get('/services', [ServiceController::class, 'index']);
$router->get('/services/new', [ServiceController::class, 'new']);
$router->post('/services/new', [ServiceController::class, 'new']);
$router->get('/services/edit', [ServiceController::class, 'edit']);
$router->post('/services/edit', [ServiceController::class, 'edit']);
$router->post('/services/delete', [ServiceController::class, 'delete']);

// Checks and validates existing routes, and assigns controller functions
$router->checkRoutes();
