<?php


include("db_info.php");

if(isset($_GET["user_id"])){
    $id = $_GET["user_id"];
    // decrypt id
    // ------------------------
}else {
    die("ID was not Received!");
}

if(isset($_GET["friend_id"])){
    $friend_id = $_GET["friend_id"];
}else {
    die("ID to request was not Received!");
}

$query = $mysqli->prepare("DELETE FROM user_friend WHERE (user_friend.user_id=? AND user_friend.friend_id=?) OR (user_friend.user_id=? AND user_friend.friend_id=?);"); 
$query->bind_param("iiii", $id, $friend_id,$friend_id,$id);
$query->execute();

echo "Removed friend.";

$query->close();
$mysqli->close();

?>