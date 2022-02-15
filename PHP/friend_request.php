<?php

    include("db_info.php");

    if(isset($_GET["user_id"])){
        $id = $_GET["user_id"];
        // decrypt id
        // ------------------------
    }else {
        die("ID was not Received!");
    }

    $query=$mysqli->prepare("SELECT users.user_id,users.user_name FROM users WHERE users.user_id IN(SELECT from_user_id FROM friend_requests WHERE to_user_id=?) AND users.user_id NOT IN(SELECT to_user_id FROM blocks WHERE from_user_id=?);");
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