<?php


include("db_info.php");
include("secure_id.php");
$_POST = json_decode(file_get_contents('php://input'), true); //creates array of input sent from axios post method
$array_response = [];

if(isset($_POST["user_id"])){
    $id = $_POST["user_id"];
    $id=decrypt($id);
}else {
    $array_response["message"] = "Id was not received.";
    $json_response = json_encode($array_response);
    return $json_response;
}

if(isset($_POST["post_id"])){
    $post_id = $_POST["post_id"];
}else {
    $array_response["message"] = "Post id was not received.";
    $json_response = json_encode($array_response);
    return $json_response;
}


if(isset($_POST["action"])){
    $action = $_POST["action"];  //like or unlike
}else {
    $array_response["message"] = "Action was not received.";
    $json_response = json_encode($array_response);
    return $json_response;
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
