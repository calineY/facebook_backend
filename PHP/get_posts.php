<?php

    include("db_info.php");

    if(isset($_GET["user_id"])){
        $id = $_GET["user_id"];
        // decrypt id
        // ------------------------
    }else {
        die("ID was not Received!");
    }

    $query=$mysqli->prepare("SELECT users.user_picture,users.user_name,posts.post_id,posts.post_content,posts.post_date,(SELECT COUNT(post_likes.id) from post_likes WHERE post_likes.post_id=posts.post_id) AS nb_likes FROM posts,users WHERE posts.user_id IN(SELECT friend_id FROM user_friends WHERE user_id=? UNION SELECT user_id FROM user_friends WHERE friend_id=? UNION SELECT user_id FROM users WHERE user_id=?) AND users.user_id=posts.user_id ORDER BY posts.post_date DESC;");
    $query->bind_param("iii",$id,$id,$id);
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