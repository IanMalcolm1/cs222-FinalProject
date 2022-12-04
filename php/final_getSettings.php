<?php
//setup
$data = file_get_contents('php://input');
$data = json_decode($data);

//more setup
$mysqli = new mysqli("localhost", "root", "", "finalprojtest", 3306);
if ( $mysqli->connect_errno ) {
    exit ("Failed to connect to MySQL: (".$mysqli->connect_errno.") ".$mysqli->connect_error);
}

/* Main 'loop' */
if (!getPrefs( $data->id, $mysqli )) {
    $query = "INSERT INTO user_prefs (account_id,theme) VALUES (".$data->id.", '0')";
    if (!$mysqli->query($query)) {
        exit ($mysqli->error);
    }
    //if successful, just run getPrefs again with a (hopefully) guaranteed success
    getPrefs( $data->id, $mysqli );
}


/* Attempts to get existing preference(s). Returns false if none found */
function getPrefs($userid, &$mysqli) {
    $query = "SELECT theme FROM user_prefs WHERE account_id='".$userid."'";

    $prefs = $mysqli->query($query);

    //error
    if ($prefs == false) {
        exit ($mysqli->error);
    }
    //no existing record
    else if ($prefs->num_rows == 0) {
        return false;
    }
    //success: return theme id
    else {
        print ($prefs->fetch_row()[0]);
        return true;
    }
}

?>