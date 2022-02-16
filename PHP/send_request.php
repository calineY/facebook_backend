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
    $request_to_id = $_POST["to_user_id"];
}else {
    $array_response["message"] = "Id to request was not received.";
    $json_response = json_encode($array_response);
    return $json_response;
}

if(isset($_POST["action"])){  //send or unsend
    $action = $_POST["action"];
}else {
    $array_response["message"] = "Action was not received.";
    $json_response = json_encode($array_response);
    return $json_response;
}

if ($action=="send"){   //send request
    $query = $mysqli->prepare("INSERT INTO friend_requests(from_user_id,to_user_id) VALUES (?,?);"); 
    $query->bind_param("ii", $id,$to_user_id);
    $query->execute();

    echo "Request sent";
}

if ($action=="unsend"){  //if request is send, delete
    $query2 = $mysqli->prepare("DELETE FROM friend_requests WHERE from_user_id=? AND to_user_id=?;"); 
    $query2->bind_param("ii",$id,$to_user_id);
    $query2->execute();

    echo "Request unsent";
} 
$query->close();
$mysqli->close();
?>