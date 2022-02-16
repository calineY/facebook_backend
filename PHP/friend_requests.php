<?php

    include("db_info.php");
    include("secure_id.php");
    $_POST = json_decode(file_get_contents('php://input'), true); //creates array of input sent from axios post method
    $array_response = [];

    if(isset($_POST["user_id"])){
        $id = $_POST["user_id"]; //get user id to get all of his requests
        $id=decrypt($id);  //decrypt id sent from frontend
    }else {
        $array_response["message"] = "Id was not received.";
        $json_response = json_encode($array_response);
        return $json_response;
    }

    $query=$mysqli->prepare("SELECT users.user_picture,users.user_id,users.user_name FROM users WHERE users.user_id IN(SELECT from_user_id FROM friend_requests WHERE to_user_id=?) AND users.user_id NOT IN(SELECT to_user_id FROM blocks WHERE from_user_id=?);");
    $query->bind_param("ii", $id,$id);
    $query->execute();
    $array = $query->get_result();


    while($user = $array->fetch_assoc()){
        $array_response[] = $user;
    }

    $json_response = json_encode($array_response);
    echo $json_response;

    $query->close();
    $mysqli->close();
?>