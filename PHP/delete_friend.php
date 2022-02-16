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

if(isset($_POST["friend_id"])){
    $friend_id = $_POST["friend_id"];
}else {
    $array_response["message"] = "Friend Id was not received.";
    $json_response = json_encode($array_response);
    return $json_response;
}
//query will delete user_friend row either way
$query = $mysqli->prepare("DELETE FROM user_friends WHERE (user_friends.user_id=? AND user_friends.friend_id=?) OR (user_friends.user_id=? AND user_friends.friend_id=?);"); 
$query->bind_param("iiii", $id, $friend_id,$friend_id,$id);
$query->execute();

echo "Removed friend.";

$query->close();
$mysqli->close();

?>