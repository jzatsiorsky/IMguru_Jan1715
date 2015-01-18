<?php

    require(__DIR__ . "/../includes/config.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$userid = $_POST["userid"];
			$gameid = $_POST["gameid"];

			query("INSERT INTO mygames VALUES (?, ?)", $userid, $gameid);
		}

?>