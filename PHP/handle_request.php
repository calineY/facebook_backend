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

if(isset($_POST["to_user_id"])){
    $friend_id = $_POST["to_user_id"];
}else {
    die("ID to request was not Received!");
}

if(isset($_POST["action"])){
    $action = $_POST["action"];
}else {
    die("Action was not Received!");
}

if ($action=="accept" || $action=="delete"){
    if ($action=="accept"){  //if accepted add to user_friend table
        $query = $mysqli->prepare("INSERT INTO user_friends(user_id,friend_id) VALUES (?,?);"); 
        $query->bind_param("ii", $id, $friend_id);
        $query->execute();

        echo "Friend added";
    }
    if ($query){  //delete request either way
        $query2 = $mysqli->prepare("DELETE FROM friend_requests WHERE friend_requests.from_user_id=? AND friend_requests.to_user_id=?;"); 
        $query2->bind_param("ii",$friend_id,$id);
        $query2->execute();
        if($action=="delete"){
            echo "Request ignored";
        }
    }
}
$query->close();
$mysqli->close();

?>