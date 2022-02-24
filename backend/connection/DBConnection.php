<?php
namespace Backend\Connection;

use mysqli;

class DBConnection
{
    const SERVERNAME = "localhost";
    const USERNAME = "root";
    const PASSWORD = "";
    CONST DB = "smart_school_manager";

    public function __construct(){

    }
    public function connect(){
        $con = new MySQLi(self::SERVERNAME, self::USERNAME, self::PASSWORD);
        if($con->connect_error){
            die("Connection failed. " .$con->connect_error);
        }
        $db = $con->select_db(self::DB);
        if($db === false){
            die("Error: DB selection failed".$con->error);
        }
        return $con;
    }

    public function getDB(){
        return self::DB;
    }

    public function closeConnection($con){
        $con->close();
    }
}