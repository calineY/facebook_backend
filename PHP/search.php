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
    
    //get users that did not block the user
    $query=$mysqli->prepare("SELECT user_id,user_name FROM users WHERE user_id NOT IN(SELECT from_user_id FROM blocks WHERE to_user_id=? UNION SELECT user_id FROM users where user_id=?);");
    $query->bind_param("ss", $id,$id);
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