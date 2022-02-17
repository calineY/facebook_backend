<?php

include("db_info.php");
$_POST = json_decode(file_get_contents('php://input'), true);  //creates array of input sent from axios post method
$array_response = [];

//data validation
if(isset($_POST["email"]) && isset($_POST["user_name"]) && isset($_POST["password"]) && isset($_POST["password_check"]) && isset($_POST['file']) && isset($_POST['extension'])){
    // if (!(preg_match('/[A-Za-z]/', $_POST["password"])) || !(preg_match('/[0-9]/', $_POST["password"])) || !(strlen($_POST["password"])<8)) {
    //     $array_response["message"] = "weak password.";
    //     $json_response = json_encode($array_response);
    //     return $json_response;
    // }
    // if ($_POST["password"]!=$_POST["password_check"]){
    //     $array_response["message"] = "Passwords don't match.";
    //     $json_response = json_encode($array_response);
    //     return $json_response;
    // }
    // if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    //     $array_response["message"] = "Invalid email.";
    //     $json_response = json_encode($array_response);
    //     return $json_response;
    // }
    $email = $mysqli->real_escape_string($_POST["email"]);
    $name = $mysqli->real_escape_string($_POST["user_name"]);
    $password = $mysqli->real_escape_string($_POST["password"]); 
    $password = hash("sha256",$password);
    $image = $_POST['file'];
    $extension = $_POST['extension'];
    $valid_extensions = array("jpg","jpeg","png");
    //$image = base64_decode($image);

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
    if(in_array($extension, $valid_extensions)){
        $image_name = time() . '.' . $extension;
        $upload_path = '../images/'. $image_name;

        $query = $mysqli->prepare("INSERT INTO users(user_name,user_email,password,user_picture) VALUES (?,?,?,?)"); 
        $query->bind_param("ssss", $name, $email, $password, $image_name);
        $query->execute();

        file_put_contents($upload_path, $image);
        
    }else {
        $array_response["message"] = "Please enter a valid picture that ends with ('.jpg','.jpeg','.png')";
        $json_response = json_encode($array_response);
        return $json_response;
    }
    echo "User created";
}
$query->close();
$mysqli->close();
?>