<?php

include("db_info.php");



if(isset($_GET["user_id"])){
    $id = $_GET["user_id"];
    // decrypt id
    // ------------------------
}else {
    die("ID was not Received!");
}

if(isset($_GET["to_user_id"])){
    $friend_id = $_GET["to_user_id"];
}else {
    die("ID to request was not Received!");
}

if(isset($_GET["action"])){
    $action = $_GET["action"];
}else {
    die("Action was not Received!");
}

if ($action=="accept" || $action=="delete"){
    if ($action=="accept"){  //if accepted add to user_friend table
        $query = $mysqli->prepare("INSERT INTO user_friend(user_id,friend_id) VALUES (?,?),(?,?);"); 
        $query->bind_param("iiii", $id, $friend_id,$friend_id,$id);
        $query->execute();

        echo "Friend added";
    }
    if ($query){  //delete request either way
        $query2 = $mysqli->prepare("DELETE FROM friend_request WHERE friend_request.from_user_id=? AND friend_request.to_user_id=?;"); 
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