<?php


include("db_info.php");
include("secure_id.php");
$_POST = json_decode(file_get_contents('php://input'), true);

if(isset($_POST["post_id"])){
    $post_id = $_POST["post_id"];
}else {
    die("post ID was not Received!");
}

$query = $mysqli->prepare("DELETE FROM posts WHERE post_id=?;"); 
$query->bind_param("i",$post_id);
$query->execute();


$query = $mysqli->prepare("DELETE FROM post_likes WHERE post_id=?;"); 
$query->bind_param("i",$post_id);
$query->execute();

echo "Post deleted";

$query->close();
$mysqli->close();
?>