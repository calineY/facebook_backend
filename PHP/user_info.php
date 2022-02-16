<?php

    include("db_info.php");
    include("secure_id.php");
    $_POST = json_decode(file_get_contents('php://input'), true);  //creates array of input sent from axios post method
    $array_response = [];

    if(isset($_POST["user_id"])){
        $id = $_POST["user_id"];
        $id=decrypt($id);
    }else {
        $array_response["message"] = "Id was not received.";
        $json_response = json_encode($array_response);
        return $json_response;
    }

    $query=$mysqli->prepare("SELECT user_picture,user_name FROM users WHERE user_id=?;"); //get user picture and user name
    $query->bind_param("i", $id);
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