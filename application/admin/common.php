<?php

function validateMsg($yes_no,$msg=""){
    $resp = [];
    if($yes_no=="yes"){
        $resp["code"]=1;
        $resp["msg"]=$msg;
    }else{
        $resp["code"]=0;
        $resp["msg"]=$msg;
    }
    return $resp;
}

