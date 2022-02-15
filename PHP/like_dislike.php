<?php


include("db_info.php");

if(isset($_GET["user_id"])){
    $id = $_GET["user_id"];
    // decrypt id
    // ------------------------
}else {
    die("ID was not Received!");
}

if(isset($_GET["post_id"])){
    $post_id = $_GET["post_id"];
}else {
    die("Post ID was not received!");
}


if(isset($_GET["action"])){
    $action = $_GET["action"];
}else {
    die("Action was not Received!");
}


if ($action=="like"){ 
    $query = $mysqli->prepare("INSERT INTO post_likes (post_id,user_id) VALUES (?, ?);"); 
    $query->bind_param("ii", $post_id,$id);
    $query->execute();

    echo "Post liked.";
}

if ($action=="dislike"){
    $query2 = $mysqli->prepare("DELETE FROM post_likes WHERE post_id=? AND user_id=?;"); 
    $query2->bind_param("ii",$post_id,$id);
    $query2->execute();

    echo "Post unliked";
}  
    


?>
