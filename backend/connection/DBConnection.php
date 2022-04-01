<?php
namespace Backend\Connection;

use mysqli;

class DBConnection
{
    private $cleardb_url;
    private $cleardb_server;
    private $cleardb_username;
    private $cleardb_password;
    private $cleardb_db;

//    const SERVERNAME = "us-cdbr-east-05.cleardb.net";
//    const USERNAME = "bf010ca2e782f7";
//    const PASSWORD = "7c05bc7e";
//    CONST DB = "heroku_f356ae46764aba9";

    public $active_group;
    public $query_builder;

    public function __construct(){
        $this->cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
        $this->cleardb_server = $this->cleardb_url["host"];
        $this->cleardb_username = $this->cleardb_url["user"];
        $this->cleardb_password = $this->cleardb_url["pass"];
        $this->cleardb_db = substr($this->cleardb_url["path"],1);

        $this->active_group = 'default';
        $this->query_builder = FALSE;
    }
    public function connect(){
        $con = new MySQLi($this->cleardb_server, $this->cleardb_username, $this->cleardb_password,$this->cleardb_db);
        if($con->connect_errno){
            return "Connection failed. " .$con->connect_errno;
        }
        return $con;
    }

    public function getClearDB(){
        return $this->cleardb_db;
    }

    public function closeConnection($con){
        $con->close();
    }
}