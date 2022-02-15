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
    $to_user_id = $_POST["to_user_id"];
}else {
    die("ID to block/unblock was not Received!");
}


if(isset($_POST["action"])){
    $action = $_POST["action"];
}else {
    die("Action was not Received!");
}


if ($action=="block"){ 
    $query = $mysqli->prepare("INSERT INTO blocks (from_user_id,to_user_id) VALUES (?, ?);"); 
    $query->bind_param("ii", $id,$to_user_id);
    $query->execute();

    echo "User blocked";
}

if ($action=="unblock"){
    $query2 = $mysqli->prepare("DELETE FROM blocks WHERE from_user_id=? AND to_user_id=?;"); 
    $query2->bind_param("ii",$id,$to_user_id);
    $query2->execute();

    echo "User unblocked";
}  
    

?>
