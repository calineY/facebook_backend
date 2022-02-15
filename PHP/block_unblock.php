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
    $to_user_id = $_GET["to_user_id"];
}else {
    die("ID to block/unblock was not Received!");
}


if(isset($_GET["action"])){
    $action = $_GET["action"];
}else {
    die("Action was not Received!");
}


if ($action=="block"){ 
    $query = $mysqli->prepare("INSERT INTO block (from_user_id,to_user_id) VALUES (?, ?);"); 
    $query->bind_param("ii", $id,$to_user_id);
    $query->execute();

    echo "User blocked";
}

if ($action=="unblock"){
    $query2 = $mysqli->prepare("DELETE FROM block WHERE from_user_id=? AND to_user_id=?;"); 
    $query2->bind_param("ii",$id,$to_user_id);
    $query2->execute();

    echo "User unblocked";
}  
    

?>
