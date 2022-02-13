<?php

    include("db_info.php");

    if(isset($_GET["user_id"])){
        $id = $_GET["user_id"];
        // decrypt id
        // ------------------------
    }else {
        die("ID was not Received!");
    }

    $query=$mysqli->prepare("SELECT user.user_id,user.user_name FROM user WHERE user.user_id IN(SELECT from_user_id FROM friend_request WHERE to_user_id=?) AND user.user_id NOT IN(SELECT to_user_id FROM block WHERE from_user_id=?);");
    $query->bind_param("ss", $id,$id);
    $query->execute();
    $array = $query->get_result();

    $array_response = [];
    while($user = $array->fetch_assoc()){
        $array_response[] = $user;
    }

    $json_response = json_encode($array_response);
    echo $json_response;

    $query->close();
    $mysqli->close();
?>