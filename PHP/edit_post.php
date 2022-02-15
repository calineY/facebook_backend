<?php


include("db_info.php");
$_POST = json_decode(file_get_contents('php://input'), true);

if(isset($_POST["post_id"])){
    $post_id = $_POST["post_id"];
}else {
    die("post ID was not Received!");
}

if(isset($_POST["post_content"])){
    $post_content = $_POST["post_content"];
}else {
    die("Fill post content.");
}

$query = $mysqli->prepare("UPDATE posts SET post_content =? WHERE post_id=?;"); 
$query->bind_param("ss",$post_content,$post_id);
$query->execute();

echo "Post edited";

$query->close();
$mysqli->close();
?>