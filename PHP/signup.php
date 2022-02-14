<?php

include("db_info.php");
$_POST = json_decode(file_get_contents('php://input'), true);

if(isset($_POST["email"]) && isset($_POST["user_name"]) && isset($_POST["password"]) && isset($_POST["password_check"]) && isset($_POST['file']) && isset($_POST['extension'])){
    $email = $mysqli->real_escape_string($_POST["email"]);
    $name = $mysqli->real_escape_string($_POST["user_name"]);
    $password = $mysqli->real_escape_string($_POST["password"]); 
    $password = hash("sha256",$password);
    $image = $_POST['file'];
    $extension = $_POST['extension'];
    $valid_extensions = array("jpg","jpeg","png");
    $image = base64_decode($image);

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
        $upload_path = '../images/'. $image_name;

        $query = $mysqli->prepare("INSERT INTO user(user_name,user_email,password,user_picture) VALUES (?,?,?,?)"); 
        $query->bind_param("ssss", $name, $email, $password, $image_name);
        $query->execute();

        file_put_contents($upload_path, $image);
        
    }else {
        die("Please enter a valid picture that ends with ('.jpg','.jpeg','.png')");
    }
    echo "User created";
}
$query->close();
$mysqli->close();
?>