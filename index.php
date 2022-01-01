<?php

require_once 'vendor/autoload.php';

session_start();

$router = new Router();

$router->get('/', function() {
    header('Location: /login');
});

$router->get('/login', ['authController', 'showLoginForm']);
$router->post('/login', ['authController', 'login']);

$router->get('/register', ['authController', 'showRegisterForm']);
$router->post('/register', ['authController', 'register']);

$router->get('/logout', ['authController', 'logout']);


$router->get('/dashboard', ['dashboardController', 'showDashboard']);

$router->post('/setup-budget', ['dashboardController', 'setbudget']);

$router->post('/add-expense', ['dashboardController', 'addExpense']);

$router->resolve();