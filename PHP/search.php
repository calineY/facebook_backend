<?php

    include("db_info.php");
    include("secure_id.php");
    $_POST = json_decode(file_get_contents('php://input'), true);

    if(isset($_POST["user_id"])){
        $id = $_POST["user_id"];
        $id=decrypt($id);
    }else {
        die("ID was not Received!");
    }

    $query=$mysqli->prepare("SELECT user_id,user_name FROM users WHERE user_id NOT IN(SELECT from_user_id FROM blocks WHERE to_user_id=?);");
    $query->bind_param("s", $id);
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