<?php

header("Access-Control-Allow-Origin: *");

include("db_info.php");
include("secure_id.php");

if(isset($_POST["email"])){
    $email = $mysqli->real_escape_string($_POST["email"]);
}else{
    die("Please fill the email.");
}

if(isset($_POST["password"])){
    $password = $mysqli->real_escape_string($_POST["password"]);
    $password = hash("sha256", $password); //hash password to save in database
}else{
    die("Please fill the password.");
}


$query = $mysqli->prepare("SELECT user_id FROM user WHERE user_email = ? AND password = ?");
$query->bind_param("ss", $email, $password);
$query->execute();

$query->store_result();
$num_rows = $query->num_rows;
$query->bind_result($id);
$query->fetch();

$array_response = [];

if($num_rows == 0){
    $array_response["status"] = "User not found!";
}else{
    $array_response["status"] = "Logged In !";
    $array_response["user_id"] = encrypt($id) ;
}
 
$json_response = json_encode($array_response);
echo $json_response;

$query->close();
$mysqli->close();

?>
