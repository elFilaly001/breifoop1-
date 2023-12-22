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
    public function showOffre()
    {
        $sql = "select * from jobs";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
    public function addOffer($Titre, $Descr, $Company, $Location, $img)
    {
        $sql = "insert into jobs values (NUll , ? , ?, ? , ? ,'Actif', CURDATE(), ? )";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$Titre, $Descr, $Company, $Location, $img]);
    }
    public function findOffer($keyword, $Company, $Location)
    {
        $sql = "select * from jobs where title like '%$keyword%' and company like '%$Company%' and location like '%$Location%'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
}
