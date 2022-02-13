<?php

function encrypt($id){  //to encrypt id before sending response
    $id1=$id+3;
    return time().'a'.$id1.':'.rand(1,1000).'e'.rand(1,100);

}

function decrypt($encrypted_id){  //to decrypt id before sending to databse
    $temp= explode("a",$encrypted_id);
    $res=explode(":",$temp[1]);
    $res=$res[0];
    $res=$res-3;
    return $res;
}

?>