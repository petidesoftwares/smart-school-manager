<?php


namespace Backend\Authentication;


use Backend\Connection\DBConnection;

class Auth
{
    public function auth( $data=[]){
        if(count($data)!=2){
            return "Error: Array length must be 2 only!";
        }
        $connect = new DBConnection();
        $con = $connect->connect();
        $queryArray =["SELECT email, password FROM staff WHERE email = ? AND password = ?","SELECT email, password FROM teacher WHERE email = ? AND password = ?","SELECT email, password FROM parent WHERE email = ? AND password = ?"];
        $result =null;
        foreach ($queryArray as $stm){
            $stmQuery = $con->prepare($stm);
            $stmQuery->bind_param("ss", ...$data);
            $stmQuery->execute();
            $user = $stmQuery->get_result();
            if ($user->fetch_assoc() === null){
               $result = "Not found";
            }else{
                $result = $user->fetch_assoc();
                break;
            }
        }
        return $result;
    }

}