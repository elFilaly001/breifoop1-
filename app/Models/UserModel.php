<?php


namespace App\Models;

use App\Models\Database;

use PDO;
use PDOException;

class UserModel
{
    private $db;

    public function __construct()
    {
        // Get an instance of the Database class
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllUsers()
    {

        try {
            // Fetch data from the "users" table
            $sql = "select * from users";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Fetch data as an associative array
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    // $user = array_keys["username"=> "abdeljalil"]
    public function findUserBy($colname, $value)
    {
        try {
            // Fetch data from the "users" table
            $sql = "select * from users where $colname = '$value'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function addUser($username, $usermail, $password)
    {
        try {
            $sql = "insert into users values(null , '$username', '$usermail' , '$password' , 'Candidat')";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
