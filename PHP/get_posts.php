<?php

    include("db_info.php");

    if(isset($_GET["user_id"])){
        $id = $_GET["user_id"];
        // decrypt id
        // ------------------------
    }else {
        die("ID was not Received!");
    }

    $query=$mysqli->prepare("SELECT user.user_picture,user.user_name,post.post_content,post.post_date,(SELECT COUNT(post_like.id) from post_like WHERE post_like.post_id=post.post_id) AS nb_likes FROM post,user WHERE post.user_id IN(SELECT friend_id FROM user_friend WHERE user_id=? UNION SELECT user_id FROM user WHERE user_id=?) AND user.user_id=post.user_id ORDER BY post.post_date DESC;");
    $query->bind_param("ii",$id,$id);
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