<?php

$mysqli = new mysqli("localhost", "root", "", "finalprojtest", 3306);
if ( $mysqli->connect_errno ) {
    exit ("Failed to connect to MySQL: (".$mysqli->connect_errno.") ".$mysqli->connect_error);
}

$query = "UPDATE user_prefs SET theme='".$_POST['theme']."' WHERE account_id='".$_POST['id']."'";

if (!$mysqli->query($query)) {
    exit($mysqli->error);
}

else {
    echo $_POST['theme'];
}

?>