<?php


namespace Backend\Database;


use Backend\Connection\DBConnection;

class DatabaseUtils
{

    public static function getAllTableData($con, $table){
        $query = 'SELECT * FROM '.$table;
        $stm = $con->prepare($query);
        $stm->execute();
        $items =[];
        $result = $stm->get_result();
        $stm->close();
        while ($rows = $result->fetch_assoc()){
            $items[] = $rows;
        }
        return json_encode($items);
    }

    public static function queryAllWithRelationship($con, $table,$relatedTable){
        $query = 'SELECT * FROM '.$table.','.$relatedTable;
        $stm = $con->prepare($query);
        $stm->execute();
        $items =[];
        $result = $stm->get_result();
        $stm->close();
        while ($rows = $result->fetch_assoc()){
            $items[] = $rows;
        }
        return json_encode($items);
    }

    public static function getAllByKey($con, $table, $keyName){
        $itemsArray = [];
        $paramDataType = "";
        $searchKeys = "";
        foreach ($keyName as $key=>$datum){
            if($key === array_key_last($keyName)){
                $searchKeys .=$key."=?";
                $itemsArray[] = $datum;
            }else{
                $searchKeys .=$key."=? AND ";
                $itemsArray[] = $datum;
            }

            $dataType = gettype($datum);
            switch ($dataType){
                case "integer":
                    $paramDataType .="i";
                    break;
                case "double":
                    $paramDataType .="d";
                    break;
                case "string":
                    $paramDataType .="s";
                    break;
                case "blob":
                    $paramDataType .="b";
                    break;
                default:
                    return;
            }
        }

        $query = 'SELECT * FROM '.$table.' WHERE '.$searchKeys;
        $stm = $con->prepare($query);
        $stm->bind_param($paramDataType, ...$itemsArray);
        $stm->execute();
        $users =[];
        $result = $stm->get_result();
        $stm->close();
        while ($rows = $result->fetch_assoc()){
            $users[] = $rows;
        }
        return json_encode($users);
    }

    public static function queryWithDirectRelationshipAndConstraints($con, $table, $relatedTable, $keyName){
        $itemsArray = [];
        $paramDataType = "";
        $searchKeys = "";
        foreach ($keyName as $key=>$datum){
            if($key === array_key_last($keyName)){
                $searchKeys .=$key."=?";
                $itemsArray[] = $datum;
            }else{
                $searchKeys .=$key."=? AND ";
                $itemsArray[] = $datum;
            }

            $dataType = gettype($datum);
            switch ($dataType){
                case "integer":
                    $paramDataType .="i";
                    break;
                case "double":
                    $paramDataType .="d";
                    break;
                case "string":
                    $paramDataType .="s";
                    break;
                case "blob":
                    $paramDataType .="b";
                    break;
                default:
                    return;
            }
        }

        $query = 'SELECT * FROM '.$table.','.$relatedTable.' WHERE '.$table.'.id = '.$relatedTable.'.id AND '.$searchKeys;
        $stm = $con->prepare($query);
        $stm->bind_param($paramDataType, ...$itemsArray);
        $stm->execute();
        $users =[];
        $result = $stm->get_result();
        $stm->close();
        while ($rows = $result->fetch_assoc()){
            $users[] = $rows;
        }
        return json_encode($users);
    }

    public static function createQuery($con, $table, $data){
        $columns = "";
        $dataArray =[];
        $valueIndexString = "";
        $paramDataType = "";
        foreach ($data as $key=>$datum){
            if($key === array_key_last($data)){
                $columns .= $key;
                $valueIndexString .="?";
                $dataArray[] = $datum;
            }else{
                $columns .= $key.",";
                $valueIndexString .="?, ";
                $dataArray[] = $datum;
            }

            $dataType = gettype($datum);
            switch ($dataType){
                case "integer":
                    $paramDataType .="i";
                    break;
                case "double":
                    $paramDataType .="d";
                    break;
                case "string":
                    $paramDataType .="s";
                    break;
                case "blob":
                    $paramDataType .="b";
                    break;
                default:
                    return;
            }
        }
        $query = "INSERT INTO ".$table." (".$columns.") VALUES (".$valueIndexString.")";
        $stmtQuery = $con->prepare($query);
        $stmtQuery->bind_param($paramDataType, ...$dataArray);
        $stmtQuery->execute();
        $stmtQuery->close();
        return "successful";
    }

    public static function getLastInsertedID($con, $table){
        $stm = $con->prepare('SELECT id FROM '.$table.' ORDER BY id DESC');
        $stm->execute();
        $result = $stm->get_result()->fetch_assoc();
        $stm->close();
        return $result['id'];
    }

    public static function getDefaultValue($table, $attribute){
        $conn = new DBConnection();
        $con = $conn->connect();
        $db = DBConnection::DB;
//        $queryDefault = 'SELECT COLUMN_DEFAULT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = "'.DBConnection::DB.'" AND TABLE_NAME="'.$table.'" AND COLUMN_NAME ="'.$attribute.'"';
        $queryDefault = 'SELECT COLUMN_DEFAULT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME= ? AND COLUMN_NAME = ?';
        $stm = $con->prepare($queryDefault);
        $stm->bind_param("sss", $db,$table, $attribute);
        $result = $stm->execute();
        $stm->close();
        while($row = $result->fetch_assoc()){
            return $row['COLUMN_DEFAULT'];
        }
    }

    public static function query($con, $query, $data=[]){
        $paramDataType = "";
        $dataArray = [];
        foreach ($data as $key=>$datum){
            $dataArray[] = $datum;
            $dataType = gettype($datum);
            switch ($dataType){
                case "integer":
                    $paramDataType .="i";
                    break;
                case "double":
                    $paramDataType .="d";
                    break;
                case "string":
                    $paramDataType .="s";
                    break;
                case "blob":
                    $paramDataType .="b";
                    break;
                default:
                    return;
            }
        }
        $stm = $con->prepare($query);
        $stm->bind_param($paramDataType, ...$dataArray);
        $stm->execute();
        $result = $stm->get_result();
        $stm->close();
        $resultArray = [];
        while($row = $result->fetch_assoc()){
            $resultArray[] = $row;
        }
        return json_encode($resultArray);
    }

    public static function queryDirect($con, $query){
        $stm = $con->prepare($query);
        $stm->execute();
        $result = $stm->get_result();
        $stm->close();
        $resultArray = [];
        while($row = $result->fetch_assoc()){
            $resultArray[] = $row;
        }
        return json_encode($resultArray);
    }

}