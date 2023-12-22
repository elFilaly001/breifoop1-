<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\Core\guest;


$controller = new HomeController();
$logincheck = new LoginController();
$guest = new guest();



$route = isset($_GET['route']) ? $_GET['route'] : 'home';

// Instantiate the controller based on the route
// $privateroutes = ['dashbord', 'candidat', 'offre', 'contact'];
// if (in_array($route, $privateroutes)) {
//     $role = $logincheck->usernotallowed();
// }

switch ($route) {
    case 'home':
        $controller->index();
        break;
    case 'dashbord':
        $guest->handle() ? $controller->dashbord() : die();
        break;
    case 'candidat':
        $guest->handle() ? $controller->candidat() : die();
        break;
    case 'offre':
        $guest->handle() ? $controller->offre() : die();
        break;
    case 'contact':
        $guest->handle() ? $controller->contact() : die();
        break;
    case 'fetchMoreUsers':
        $controller->fetchMoreUsers();
        break;
    case 'login':
        $controller->login_page();
        break;
    case 'register':
        $controller->register_page();
        break;
    case 'post_login':

        $logincheck->login();
        break;
    case 'post_register':

        $logincheck->register();
        break;
    case 'denied':
        $controller->denied();
        break;
    case 'addOffer':
        $controller->addOfre();
        break;
    default:
        // Handle 404 or redirect to the default route
        header('HTTP/1.0 404 Not Found');
        exit('Page not found');
}

// Execute the controller action
