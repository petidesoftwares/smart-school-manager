<?php
use Backend\Connection\DBConnection;
use Backend\Models\ParentOthername;
use Backend\Models\Parents;

require ("../../vendor/autoload.php");

if (isset($_POST)) {
    $parentID = $_POST['id'];

    $conn = new DBConnection();
    $con = $conn->connect();

    $parent = new Parents();
    $parentDetails = json_decode($parent->allWithKey($con, ['id' => $parentID]));
    $parentOthernameObj = new ParentOthername();
    $parentOthername = json_decode($parentOthernameObj->allWithKey($con, ["parent_id" => $parentID]));
    $othername = "NIL";
    if (count($parentOthername) > 0) {
        $othername = $parentOthername[0]->othername;
    }
    $parentDetails[0]->othername = $othername;
    echo json_encode($parentDetails);
}
