<?php


include("db_info.php");

if(isset($_GET["post_id"])){
    $post_id = $_GET["post_id"];
}else {
    die("post ID was not Received!");
}

$query = $mysqli->prepare("DELETE FROM posts WHERE post_id=?;"); 
$query->bind_param("i",$post_id);
$query->execute();

echo "Post deleted";

$query = $mysqli->prepare("DELETE FROM post_likes WHERE post_id=?;"); 
$query->bind_param("i",$post_id);
$query->execute();

echo "Post likes deleted";

$query->close();
$mysqli->close();
?>