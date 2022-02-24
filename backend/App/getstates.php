<?php

use Backend\Connection\DBConnection;
use Backend\Models\State;

include_once ("../../vendor/autoload.php");

$conn = new DBConnection();
$con = $conn->connect();

$states = new State();
echo $states->all($con);