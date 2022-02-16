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
    
    //query will select only the posts of the user
    $query=$mysqli->prepare("SELECT posts.post_id,posts.post_content,posts.post_date,
    (SELECT COUNT(post_likes.id) from post_likes WHERE post_likes.post_id=posts.post_id)
    AS nb_likes 
    FROM posts,users
    WHERE posts.user_id IN(SELECT user_id FROM users WHERE user_id=?) AND users.user_id=posts.user_id ORDER BY posts.post_date DESC;");
    $query->bind_param("s", $id);
    $query->execute();
    $array = $query->get_result();


    while($post = $array->fetch_assoc()){
        $array_response[] = $post;
    }

    $json_response = json_encode($array_response);
    echo $json_response;

    $query->close();
    $mysqli->close();
?>