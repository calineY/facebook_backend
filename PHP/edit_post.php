<?php


include("db_info.php");
$_POST = json_decode(file_get_contents('php://input'), true);
$array_response = [];

if(isset($_POST["post_id"])){
    $post_id = $_POST["post_id"];
}else {
    $array_response["message"] = "Post Id was not received.";
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

$query = $mysqli->prepare("UPDATE posts SET post_content =? WHERE post_id=?;"); 
$query->bind_param("ss",$post_content,$post_id);
$query->execute();

echo "Post edited";

$query->close();
$mysqli->close();
?>