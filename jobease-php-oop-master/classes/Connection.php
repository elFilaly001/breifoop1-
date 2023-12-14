<?php
class Connection
{

    private $host = "localhost";
    private $user = "root";
    private $pwd = "";
    private $db = "brief oop";
    public function conn()
    {
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db;
        $pdo = new PDO($dsn, $this->user, $this->pwd);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }
}
