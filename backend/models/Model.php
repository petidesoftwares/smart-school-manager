<?php


namespace Backend\Models;


use Backend\Database\DatabaseUtils;
use Common\Util;
use Connection\DBConnect;

class Model
{

    /**
     * Primary key of table if not specified
     * @var string
     */
    protected $primaryKey ="id";

    /**
     * Databaase object attributes;
     * @var
     */
    protected $fillable;

    /**
     *Database table as object
     * @var
     */
    protected $table;

    /**
     * Model constructor.
     */
    public function __construct(){
    }

    /**
     * Get the database table represented by this object
     * and return the name
     * @return mixed|string
     */
    public function getTable(){
        if($this->table === null){
            $userTable = explode('\\',strtolower(get_class($this))."s");
            return $userTable[array_key_last($userTable)];
        }
        return $this->table;
    }

    /**
     * Match or compare the array of data to be uploaded to match
     * with fillable array of attributes in the model.
     * if correctly matched then use the values to fill the database table.
     * @param array $attributes: Array of attributes and values to be
     * stored in the database.
     * @return string: return all attributes matching with the database
     * attributes of the table as a string
     */
    public function fill(array $attributes){
        $tableAttribute ="";
        $errormessage ="";
        if(count(array_diff(array_keys($attributes), $this->fillable)) === 0){
            return true;
        }
        $arrayDiff = array_diff(array_keys($attributes), $this->fillable);
        foreach ($arrayDiff as $value){
            if($value === end($arrayDiff)){
                $errormessage .= $value;
            }else{
                $errormessage .= $value .", ";
            }
        }
//        foreach ($this->fillable as $key){
//            foreach ($attributes as $index=>$value){
//                if ($key === $index){
//                    if($key !== end($this->fillable) && $value !==end($attributes)){
//                        $tableAttribute .= $key.", ";
//                    }elseif ($key !== end($this->fillable) && $value ===end($attributes)){
//                        $tableAttribute .= $key;
//                    }
//                    else{
//                        $tableAttribute .= $key;
//                    }
//                }else{
//                    if(stripos($tableAttribute,$key) !==null){
//                        continue;
//                    }else{
//                        if($this->getDefaultAttributeValue($key)===NULL){
//                            if($key !== end($this->fillable)){
//                                $tableAttribute .= $key.", ";
//                            }else{
//                                $tableAttribute .= $key;
//                            }
//                        }else{
//                            $tableAttribute .=$this->getDefaultAttributeValue($key);
//                        }
//                    }
//                }
//            }
//        }
        return "Error. The following are not valid attributes: ".$errormessage;
    }

    /**
     * Get the default value the attribute as set in the database table
     * @param $attribute: Attribute to get the default value
     * @return mixed: The default value of the attribute
     */
    public function getDefaultAttributeValue($attribute){
        return DatabaseUtils::getDefaultValue($this->getTable(),$attribute);
    }

    /**Create a new record in the database table;
     * @param array $data : Associative array of records to be created
     * @return bool|string|void : A message to confirm the success or failure of the operation.
     */
    public function create($con, $data = []){
        if(count($data) === 0){
            return "Error: Cannot create an empty record";
        }
        if($this->fill($data) !== true){
            return $this->fill($data);
        }
        $created = DatabaseUtils::createQuery($con, $this->getTable(),$data);
        return $created;
    }

    public function all($con){
        return DatabaseUtils::getAllTableData($con, $this->getTable());
    }

    public function  allWithRelationship($con, $relatedTable){
        return DatabaseUtils::queryAllWithRelationship($con,$this->getTable(), $relatedTable);
    }

    public function  allWithKey($con, $keyName=[]){
        return DatabaseUtils::getAllByKey($con, $this->getTable(), $keyName);
    }

    public function getAllWithRelationshipAndConstraints($con, $relatedTable, $keyName=[]){
        return DatabaseUtils::queryWithDirectRelationshipAndConstraints($con, $this->getTable(),$relatedTable,$keyName);
    }

    public function getLastID($con){
        return DatabaseUtils::getLastInsertedID($con, $this->getTable());
    }

}

