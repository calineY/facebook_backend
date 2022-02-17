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

if(isset($_POST["to_user_id"])){
    $friend_id = $_POST["to_user_id"];
}else {
    $array_response["message"] = "Id to request was not received.";
    $json_response = json_encode($array_response);
    return $json_response;
}

if(isset($_POST["action"])){
    $action = $_POST["action"];
}else {
    $array_response["message"] = "Action was not received.";
    $json_response = json_encode($array_response);
    return $json_response;
}

if ($action=="accept" || $action=="delete"){
    if ($action=="accept"){  //if accepted add to user_friend table
        $query = $mysqli->prepare("INSERT INTO user_friends(user_id,friend_id) VALUES (?,?);"); 
        $query->bind_param("ii", $id, $friend_id);
        $query->execute();
        $query->close();

        echo "Friend added";
    }
 //delete request either way
    $query2 = $mysqli->prepare("DELETE FROM friend_requests WHERE friend_requests.from_user_id=? AND friend_requests.to_user_id=?;"); 
    $query2->bind_param("ii",$friend_id,$id);
    $query2->execute();
    $query2->close();
    if($action=="delete"){
        echo "Request ignored";
    }

}

$mysqli->close();

?>