<?php


include("db_info.php");
include("secure_id.php");
$_POST = json_decode(file_get_contents('php://input'), true); //creates array of input sent from axios post method
$array_response = [];

if(isset($_POST["post_id"])){
    $post_id = $_POST["post_id"]; //get post id
}else {
    $array_response["message"] = "Post Id was not received.";
    $json_response = json_encode($array_response);
    return $json_response;
}

$query = $mysqli->prepare("DELETE FROM posts WHERE post_id=?;"); 
$query->bind_param("i",$post_id);
$query->execute();


$query = $mysqli->prepare("DELETE FROM post_likes WHERE post_id=?;"); //delete post likes
$query->bind_param("i",$post_id);
$query->execute();

echo "Post deleted";

$query->close();
$mysqli->close();
?>