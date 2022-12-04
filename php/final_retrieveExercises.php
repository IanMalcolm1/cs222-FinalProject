<?php
//recieve type value from javascript
$data = file_get_contents('php://input');
$data = json_decode($data);

//connect to server
$mysqli = new mysqli("localhost", "root", "", "finalprojtest", 3306);
if ( $mysqli->connect_errno ) {
    echo ("Failed to connect to MySQL: (".$mysqli->connect_errno.") ".$mysqli->connect_error);
}

else {
    $exercises = $mysqli->query("SELECT `name`,`link` FROM `exercises` PARTITION(".$data->type.")");
    if ($exercises == false) {
        echo ($mysqli->error);
    }
    else if ($exercises->num_rows == 0){
        echo ("No exercises found... (this shouldn't happen)");
    }
    else {
        $returnStr = "";
        foreach ($exercises as $exercise) {
            $returnStr .= "<a href=\"".$exercise['link']."\" target=\"_blank\">".$exercise['name']."</a><br>";
        }
        echo $returnStr;
    }
}

?>