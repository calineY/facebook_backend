<?php


include("db_info.php");

if(isset($_GET["user_id"])){
    $id = $_GET["user_id"];
    // decrypt id
    // ------------------------
}else {
    die("ID was not Received!");
}

if(isset($_GET["post_content"])){
    $post_content = $_GET["post_content"];
}else {
    die("Fill post content.");
}

$post_date = date("Y-m-d H:i:s", strtotime ("+1 hour"));;

echo date('g:ia', strtotime($post_date));


$query = $mysqli->prepare("INSERT INTO post (post_content,post_date,user_id) VALUES (?, ?,?);"); 
$query->bind_param("ssi",$post_content,$post_date,$id);
$query->execute();

echo "Post added";