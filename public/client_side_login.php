<?php

// configuration
require("../includes/config.php"); 

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
	$rows = query("SELECT * FROM users WHERE LOWER(username) = ?", strtolower($_GET["username"]) . "@" . $_GET["school"] . ".harvard.edu");

    $result = 1;

    // if we found user, check password
    if (count($rows) == 1)
    {
        // first (and only) row
        $row = $rows[0];

        // compare hash of user's input against hash that's in database
        if (crypt($_GET["password"], $row["password"]) == $row["password"])
        	$result = 0;
    }


    // output places as JSON (pretty-printed for debugging convenience)
    header("Content-type: application/json");
    print(json_encode($result, JSON_PRETTY_PRINT));

}
else
    return false;
?>