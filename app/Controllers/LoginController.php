<?php

namespace App\Controllers;



use App\Models\Database;
use App\Models\UserModel;

class LoginController
{
    private $db;

    public function __construct()
    {
        // Get an instance of the Database class
        $this->db = Database::getInstance()->getConnection();
    }
    public function login()
    {
        $email = $_POST['email'];
        $pwd = $_POST['password'];
        $userfind = new UserModel($this->db);
        $result = $userfind->findUserBy("email", $email);

        if ($result) {
            if (password_verify($pwd, $result['password'])) {
                $_SESSION['roleuser'] = $result['role_name'];
                $_SESSION['userid'] = $result['id'];
                $_SESSION['useremail'] = $email;
                if ($result['role_name'] == 'Candidat') {
                    header("Location: ?route=home");
                    die();
                } elseif ($result['role_name'] == 'Admin') {
                    header("Location: ?route=dashbord");
                    die();
                }
            } else {
                header("Location: ?route=login");
                die();
            }
        } else {
            header("Location: ?route=login");
            die();
        }
    }

    public function ifloged()
    {
        if (isset($_SESSION['useremail'])) {
            echo  $_SESSION['useremail'];
        } else { ?>
            <a href="?route=login">login</a></span>
<?php
        }
    }

    public function register()
    {
        // $name = 
    }
}
