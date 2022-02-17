<?php

include("db_info.php");
$_POST = json_decode(file_get_contents('php://input'), true);  //creates array of input sent from axios post method
$array_response = [];

//data validation
if(isset($_POST["email"]) && isset($_POST["user_name"]) && isset($_POST["password"]) && isset($_POST["password_check"])){
    // if (!(preg_match('/[A-Za-z]/', $_POST["password"])) || !(preg_match('/[0-9]/', $_POST["password"])) || !(strlen($_POST["password"])<8)) {

    $email = $mysqli->real_escape_string($_POST["email"]);
    $name = $mysqli->real_escape_string($_POST["user_name"]);
    $password = $mysqli->real_escape_string($_POST["password"]); 
    $password = hash("sha256",$password);

}else{
    $array_response["message"] = "Fill all fields.";
    $json_response = json_encode($array_response);
    return $json_response;
}

$query=$mysqli->prepare("SELECT * FROM users where user_email='$email'");
$query->execute();
$query->store_result();

if(($query->num_rows)>0){
    $array_response["message"] = "Email already exists.";
    $json_response = json_encode($array_response);
    return $json_response;
}else{

    $query = $mysqli->prepare("INSERT INTO users(user_name,user_email,password) VALUES (?,?,?)"); 
    $query->bind_param("sss", $name, $email, $password);
    $query->execute();
        
    echo "User created";
}
$query->close();
$mysqli->close();
?>