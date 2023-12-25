<?php


namespace App\Models;

use App\Models\Database;

use PDO;
use PDOException;

class OffreModel
{
    private $db;

    public function __construct()
    {
        // Get an instance of the Database class
        $this->db = Database::getInstance()->getConnection();
    }

    public function addOffer($Titre, $Descr, $Company, $Location, $img)
    {
        $sql = "insert into jobs values (NUll , ? , ?, ? , ? ,'open', CURDATE(), ? )";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$Titre, $Descr, $Company, $Location, $img]);
    }
    public function findOffer($keyword, $Company, $Location)
    {
        $sql = "select * from jobs where title like '%$keyword%' and company like '%$Company%' and location like '%$Location%' and status='open' ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function applyToOffer($user_id, $job_id)
    {
        $sql = "insert into applications values (NULL , $user_id , $job_id , 'in progress')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function allOffres()
    {
        $sql = "select * from jobs";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function controlOffre($opORcl, $job_id)
    {
        $sql = "update jobs set status =  ?  where job_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$opORcl, $job_id]);
    }
    public function controlApp($opORcl, $job_id)
    {
        $sql = "update applications set app_status =  ?  where app_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$opORcl, $job_id]);
    }
    public function all_users()
    {
        $sql = "select * FROM users u , applications a , jobs j where u.id = a.user_id and a.job_id= j.job_id and u.username= 'abdou';";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
}
