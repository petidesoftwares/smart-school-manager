<?php
namespace Backend\Connection;

use mysqli;

class DBConnection
{
//$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
//$cleardb_server = $cleardb_url["host"];
//$cleardb_username = $cleardb_url["user"];
//$cleardb_password = $cleardb_url["pass"];
//$cleardb_db = substr($cleardb_url["path"],1);

    const SERVERNAME = "us-cdbr-east-05.cleardb.net";
    const USERNAME = "bf010ca2e782f7";
    const PASSWORD = "7c05bc7e";
    CONST DB = "heroku_f356ae46764aba9";

    public $active_group;
    public $query_builder;

    public function __construct(){
        $this->active_group = 'default';
        $this->query_builder = FALSE;
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