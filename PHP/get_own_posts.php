<?php

    include("db_info.php");
    include("secure_id.php");
    $_POST = json_decode(file_get_contents('php://input'), true);

    if(isset($_POST["user_id"])){
        $id = $_POST["user_id"];
        $id=decrypt($id);
    }else {
        die("ID was not Received!");
    }

    $query=$mysqli->prepare("SELECT posts.post_id,posts.post_content,posts.post_date,
    (SELECT COUNT(post_likes.id) from post_likes WHERE post_likes.post_id=posts.post_id)
    AS nb_likes 
    FROM posts,users
    WHERE posts.user_id IN(SELECT user_id FROM users WHERE user_id=?) AND users.user_id=posts.user_id ORDER BY posts.post_date DESC;");
    $query->bind_param("s", $id);
    $query->execute();
    $array = $query->get_result();

    $array_response = [];
    while($user = $array->fetch_assoc()){
        $array_response[] = $user;
    }

    $json_response = json_encode($array_response);
    echo $json_response;

    $query->close();
    $mysqli->close();
?>