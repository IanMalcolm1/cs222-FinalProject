<?php

/*
returnData Format for user errors:
0 indicates unfilled
1 indicates invalid email
2 irrelevant to login
3 email not found in database
4 password is incorrect for given email
*/
$returnData = [
    "type" => 0 //type of error: 0 for none, 1 for user error, 2 for sql error
];

//check they filled the forms correctly
if ($_POST["password"]=="") {
    $returnData["type"] = 1;
    $returnData["pLogin"] = 0;
}
if ($_POST["email"]=="") {
    $returnData["type"] = 1;
    $returnData["eLogin"] = 0;
}
else {
    $_POST["email"] = trim($_POST["email"]);
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) ) {
        $returnData["type"] = 1;
        $returnData["eLogin"] = 1;
    }
}

//if no errors, check database for user
if ($returnData["type"]==0) {
    //connect to server
    $mysqli = new mysqli("localhost", "root", "", "finalprojtest", 3306);
    if ( $mysqli->connect_errno ) {
        $returnData["type"] = 2;
        $returnData["sql"] = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") "
            . $mysqli->connect_error;
    }

    //try to find user info
    $userInfo = $mysqli->query("SELECT `password`,`account_id` FROM `fitness_app_users` WHERE 
        `email`='".$_POST["email"]."'");
    //if error
    if ($userInfo == false) {
        $returnData["type"] = 2;
        $returnData["sql"] = $mysqli->error;
    }
    //else if email not found
    else if ($userInfo->num_rows==0) {
        $returnData["type"] = 1;
        $returnData["eLogin"] = 3;
    }
    //else check password
    else {
        $passwordAndID = $userInfo->fetch_row();
        //if input password does not match records
        if ($passwordAndID[0]!=$_POST["password"]) {
            $returnData["type"] = 1;
            $returnData["pLogin"] = 4;
        }
        //else
        else {
            $returnData["id"] = $passwordAndID[1];
        }
    }

}

echo json_encode($returnData);

?>