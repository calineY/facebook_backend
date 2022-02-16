<?php


include("db_info.php");
include("secure_id.php"); //handles id encryption/decryption

$_POST = json_decode(file_get_contents('php://input'), true); //creates array of input sent from axios post method
$array_response = [];

if(isset($_POST["user_id"])){
    $id = $_POST["user_id"];
    $id=decrypt($id);
}else {
    $array_response["message"] = "ID was not Received!";
    $json_response = json_encode($array_response);
    return $json_response;
}

if(isset($_POST["to_user_id"])){
    $to_user_id = $_POST["to_user_id"];
}else {
    $array_response["message"] = "ID to block/unblock was not received.";
    $json_response = json_encode($array_response);
    return $json_response;
}


if(isset($_POST["action"])){  //block or unblock
    $action = $_POST["action"];
}else {
    $array_response["message"] = "Action was not received.";
    $json_response = json_encode($array_response);
    return $json_response;
}


if ($action=="block"){   //if user is unblocked block
    $query = $mysqli->prepare("INSERT INTO blocks (from_user_id,to_user_id) VALUES (?, ?);"); 
    $query->bind_param("ii", $id,$to_user_id);
    $query->execute();

    echo "User blocked";
}

if ($action=="unblock"){  //if user is already blocked then unblock
    $query2 = $mysqli->prepare("DELETE FROM blocks WHERE from_user_id=? AND to_user_id=?;"); 
    $query2->bind_param("ii",$id,$to_user_id);
    $query2->execute();

    echo "User unblocked";
}  
    

?>
