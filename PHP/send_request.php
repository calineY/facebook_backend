<?php

include("db_info.php");
include("secure_id.php");
$_POST = json_decode(file_get_contents('php://input'), true);


if(isset($_POST["user_id"])){
    $id = $_POST["user_id"];
    $id=decrypt($id);
}else {
    die("ID was not Received!");
}

if(isset($_POST["to_user_id"])){
    $request_to_id = $_POST["to_user_id"];
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