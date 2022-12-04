<?php

/*
returnData Format for user errors:
0 indicates unfilled
1 indicates invalid email
2 indicates email already exists in database
3 irrelevant to sign up
4 "
*/
$returnData = [
    "type" => 0 //type of error: 0 for none, 1 for user error, 2 for sql error
];

//initial checks that forms have been filled and the email is in a valid format
if ($_POST["name"]=="") {
    $returnData["type"] = 1;
    $returnData["nameSignup"] = 0;
}
if ($_POST["password"]=="") {
    $returnData["type"] = 1;
    $returnData["pSignup"] = 0;
}
if ($_POST["email"]=="") {
    $returnData["type"] = 1;
    $returnData["eSignup"] = 0;
}
else {
    $_POST["email"] = trim($_POST["email"]); //first trim address
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) ) {
        $returnData["type"] = 1;
        $returnData["eSignup"] = 1;
    }
}

//if no errors so far, start doing database stuff
if ($returnData["type"]==0) {
    //connect to server
    $mysqli = new mysqli("localhost", "root", "", "finalprojtest", 3306);
    if ( $mysqli->connect_errno ) {
        $returnData["type"] = 2;
        $returnData["sql"] = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") "
            . $mysqli->connect_error;
    }

    //if email already exists
    else if ($mysqli->query("SELECT email FROM fitness_app_users WHERE email='".$_POST["email"]."'")
    ->num_rows > 0) {
        $returnData["type"] = 1;
        $returnData["eSignup"] = 2;
    }
    
    //if nothing went wrong, stores user data
    else {
        $_POST["name"] = trim($_POST["name"]);//first trim whitespace (no need to do this to name earlier)

        $query = "INSERT INTO `fitness_app_users`(`account_id`, `name`, `email`, `password`) 
            VALUES (NULL,'".$_POST["name"]."','".$_POST["email"]."','".$_POST["password"]."')";

        if (!$mysqli->query($query)) {
            $returnData["type"] = 2;
            $returnData["sql"] = $mysqli->error;
        }
        else {
            //gets the id created for the user
            $returnData["id"] = $mysqli->insert_id;
        }
    }

    $mysqli->close();

}

echo json_encode($returnData);

?>