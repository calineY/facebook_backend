<?php

include("db_info.php");


if(isset($_GET["user_id"])){
    $id = $_GET["user_id"];
    // decrypt id
    // ------------------------
}else {
    die("ID was not Received!");
}

if(isset($_GET["to_user_id"])){
    $request_to_id = $_GET["to_user_id"];
}else {
    die("ID to request was not Received!");
}

$query = $mysqli->prepare("INSERT INTO friend_requests(from_user_id,to_user_id) VALUES (?,?)"); 
$query->bind_param("ii", $id, $request_to_id);
$query->execute();

echo "Request sent";
$query->close();
$mysqli->close();
?>