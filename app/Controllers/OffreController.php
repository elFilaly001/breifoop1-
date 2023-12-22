<?php

namespace App\Controllers;

session_start();

use App\Models\Database;
use App\Models\OffreModel;

class offerController
{
    private $db;


    public function __construct()
    {
        // Get an instance of the Database class
        $this->db = Database::getInstance()->getConnection();
    }


    public function addOffre()
    {
        $job = new OffreModel($this->db);
        if (isset($_POST['submitOffre'])) {
            $Titre = $_POST['Titre'];
            $Descr =  $_POST['Descrption'];
            $Company =  $_POST['Company'];
            $Location =  $_POST['Location'];
            extract($_POST);
            $image_name = $_FILES['jobImg']['name'];
            $image_temp = $_FILES['jobImg']['tmp_name'];
            $image_type = $_FILES['jobImg']['type'];
            $image_size = $_FILES['jobImg']['size'];
            $image_error = $_FILES['jobImg']['error'];
            $allowed = array('jpg', 'png', 'jif');
            $image = explode('.', $image_name);
            $image_ext = strtolower(end($image));
            if ($image_error == 4) {
                echo "file is not uploaded";
            } else if ($image_size) {
                if (in_array($image_ext, $allowed)) {
                    $jobImage = uniqid() . $image_name;
                    move_uploaded_file($image_temp, $_SERVER['DOCUMENT_ROOT'] . '/breifoop1-/jobease-php-oop-master/styles/img/' . $jobImage);
                    $jobs = $job->addOffer($Titre, $Descr, $Company, $Location, $jobImage);
                    if ($jobs) {
                        header('location: ?route=dashbord');
                    }
                } else {
                    echo "file is not valid you need this extention ('jpg' , 'png' , 'jfif')";
                }
            } else {
                echo "size to file is too heigh to upload";
            }
        }
    }
}
