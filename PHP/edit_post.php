<?php


include("db_info.php");

if(isset($_GET["post_id"])){
    $post_id = $_GET["post_id"];
}else {
    die("post ID was not Received!");
}

if(isset($_GET["post_content"])){
    $post_content = $_GET["post_content"];
}else {
    die("Fill post content.");
}

$query = $mysqli->prepare("UPDATE post SET post_content =? WHERE post_id=?;"); 
$query->bind_param("ss",$post_content,$post_id);
$query->execute();

echo "Post edited";

$query->close();
$mysqli->close();
?>