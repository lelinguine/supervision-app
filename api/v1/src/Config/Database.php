<?php
    
namespace App\Config;
use PDO;
    
class Database
{
    private $dbhost;
    private $dbuser;
    private $dbpass;
    private $dbname;
        
    public function connect()
    {
        $setting = parse_ini_file("../src/Config/Setting.ini");

        $this->dbhost =  $setting['host'];
        $this->dbuser =  $setting['user'];
        $this->dbpass =  $setting['password'];
        $this->dbname =  $setting['name'];

        $dbConn = new PDO("mysql:host=$this->dbhost;dbname=$this->dbname", $this->dbuser, $this->dbpass);
        $dbConn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

        return $dbConn;
    }

    public function manageData($sql)
    {
        $conn = $this->connect();
        $stmt = $conn->query($sql);
        $data = $stmt->fetchAll();
        
        return $data;
    }
}