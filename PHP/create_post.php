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

if(isset($_POST["post_content"])){
    $post_content = $_POST["post_content"];
}else {
    die("Fill post content.");
}

$post_date = date("Y-m-d H:i:s", strtotime ("+1 hour"));


$query = $mysqli->prepare("INSERT INTO posts (post_content,post_date,user_id) VALUES (?, ?,?);"); 
$query->bind_param("ssi",$post_content,$post_date,$id);
$query->execute();

echo "Post added";


$query->close();
$mysqli->close();
?>