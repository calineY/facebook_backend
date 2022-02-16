<?php


include("db_info.php");
include("secure_id.php");

$_POST = json_decode(file_get_contents('php://input'), true);//creates array of input sent from axios post method
$array_response = [];

if(isset($_POST["user_id"])){
    $id = $_POST["user_id"];
    $id=decrypt($id);   //decrypt user id
}else {
    $array_response["message"] = "Id was not received.";
    $json_response = json_encode($array_response);
    return $json_response;
}

if(isset($_POST["post_content"])){
    $post_content = $_POST["post_content"];
}else {
    $array_response["message"] = "Post content was not received.";
    $json_response = json_encode($array_response);
    return $json_response;
}

$post_date = date("Y-m-d H:i:s", strtotime ("+1 hour"));  //add one hour to the date to match current time


$query = $mysqli->prepare("INSERT INTO posts (post_content,post_date,user_id) VALUES (?, ?,?);"); 
$query->bind_param("ssi",$post_content,$post_date,$id);
$query->execute();

echo "Post added";


$query->close();
$mysqli->close();
?>