<?php

function encrypt($id){  //to encrypt id before sending response
    $id1=$id*17;
    return time().'a'.$id1.':'.rand(1,1000).'e'.rand(1,100);

}

function decrypt($encrypted_id){  //to decrypt id before sending to database
    $temp= explode("a",$encrypted_id);
    $temp1=$temp[1];
    $res=explode(":",$temp1);
    $res1=$res[0];
    $res2=$res1/17;
    return $res2;
}

?>