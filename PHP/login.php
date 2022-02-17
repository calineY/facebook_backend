<?php


include("db_info.php");
include("secure_id.php");
$_POST = json_decode(file_get_contents('php://input'), true); //creates array of input sent from axios post method
$array_response = [];

if(isset($_POST["email"])){
    $email = $mysqli->real_escape_string($_POST["email"]);
}else{
    $array_response["message"] = "Invalid email.";
    $json_response = json_encode($array_response);
    return $json_response;
}

if(isset($_POST["password"])){
    $password = $mysqli->real_escape_string($_POST["password"]);
    //$password = hash("sha256", $password); //hash password to save in database
}else{
    $array_response["message"] = "Invalid password.";
    $json_response = json_encode($array_response);
    return $json_response;
}


$query = $mysqli->prepare("SELECT user_id FROM users WHERE user_email = ? AND password = ?");
$query->bind_param("ss", $email, $password);
$query->execute();

$query->store_result();
$num_rows = $query->num_rows;
$query->bind_result($id);
$query->fetch();



if($num_rows == 0){
    $array_response["status"] = "User not found!";
}else{
    $array_response["status"] = "Logged In !";
    $array_response["user_id"] = encrypt($id) ; //pass encrypted id
}
 
$json_response = json_encode($array_response);
echo $json_response;

$query->close();
$mysqli->close();

?>
