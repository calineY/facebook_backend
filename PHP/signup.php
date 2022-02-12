<?php

include("db_info.php");


if(isset($_POST["email"]) && isset($_POST["user_name"]) && isset($_POST["password"]) && isset($_POST["password_check"])){
    $email = $mysqli->real_escape_string($_POST["email"]);
    $name = $mysqli->real_escape_string($_POST["user_name"]);
    $password = $mysqli->real_escape_string($_POST["password"]); 
    $password = hash("sha256",$password);
}else{
    die("Please fill all fields.");
}

$query=$mysqli->prepare("SELECT * FROM user where user_email='$email'");
$query->execute();
$query->store_result();

if(($query->num_rows)>0){
    die("Email already exists");
}else{
    $query = $mysqli->prepare("INSERT INTO user(user_name,user_email,password) VALUES (?,?,?)"); 
    $query->bind_param("sss", $name, $email, $password);
    $query->execute();

    echo "User created";
}
$query->close();
$mysqli->close();
?>