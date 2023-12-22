<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\Core;
use App\Controllers\Core\guest;

class HomeController
{
    public function index()
    {
        $userModel = new UserModel();

        // Fetch data from the "users" table

        $users = $userModel->getAllUsers();
        // Your controller logic goes here
        $data = 'Hello, this is the home page!';
        $collections = ['users' => $users, "data" => $data];
        require(__DIR__ . '../../../view/index.php');
    }
    public function fetchMoreUsers()
    {

        $moreUsers = [
            ['username' => 'test user A', 'email' => 'user1@example.com'],
            ['username' => 'test user B', 'email' => 'user2@example.com'],
        ];

        // Return the data as JSON
        header('Content-Type: application/json');
        echo json_encode(['users' => $moreUsers]);
        exit;
    }
    public function login_page()
    {
        require(__DIR__ . '../../../view/login.php');
    }
    public function register_page()
    {
        require(__DIR__ . '../../../view/register.php');
    }

    public function dashbord()
    {
        require(__DIR__ . '../../../view/dashboard/dashboard.php');
    }
    public function candidat()
    {
        require(__DIR__ . '../../../view/dashboard/candidat.php');
    }
    public function offre()
    {
        require(__DIR__ . '../../../view/dashboard/offre.php');
    }
    public function contact()
    {
        require(__DIR__ . '../../../view/dashboard/contact.php');
    }
    public function Article()
    {
        require(__DIR__ . '../../../view/dashboard/Article.php');
    }

    public function denied()
    {
        require(__DIR__ . '../../../view/denied.php');
    }
    public function addOfre()
    {
        require(__DIR__ . '../../../view/dashboard/addOffer.php');
    }
}
