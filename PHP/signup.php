<?php

include("db_info.php");


if(isset($_POST["email"]) && isset($_POST["user_name"]) && isset($_POST["password"]) && isset($_POST["password_check"]) && isset($_FILES['file']['name'])){
    $email = $mysqli->real_escape_string($_POST["email"]);
    $name = $mysqli->real_escape_string($_POST["user_name"]);
    $password = $mysqli->real_escape_string($_POST["password"]); 
    $password = hash("sha256",$password);
    $image_name = $_FILES['file']['name'];
    $valid_extensions = array("jpg","jpeg","png");
    $extension = pathinfo($image_name, PATHINFO_EXTENSION);
}else{
    die("Please fill all fields.");
}

$query=$mysqli->prepare("SELECT * FROM user where user_email='$email'");
$query->execute();
$query->store_result();

if(($query->num_rows)>0){
    die("Email already exists");
}else{
    if(in_array($extension, $valid_extensions)){
        $image_name = time() . '.' . $extension;
        $upload_path = '../upload/'. $image_name;

        $query = $mysqli->prepare("INSERT INTO user(user_name,user_email,password,user_picture) VALUES (?,?,?,'$image_name')"); 
        $query->bind_param("sss", $name, $email, $password);
        $query->execute();

        move_uploaded_file($_FILES['file']['tmp_name'], $upload_path);
        
    }else {
        die("Please enter a valid picture that ends with ('.jpg','.jpeg','.png')");
    }
    echo "User created";
}
$query->close();
$mysqli->close();
?>