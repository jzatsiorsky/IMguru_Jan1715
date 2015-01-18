<?php

    require(__DIR__ . "/../includes/config.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
			$gameid = $_GET["gameid"];

			$roster = query("SELECT * FROM users INNER JOIN mygames ON users.userid = mygames.userid WHERE users.house = ? AND mygames.gameid = ?", "Adams", $gameid);
			header("Content-type: application/json");
	    	print(json_encode($roster, JSON_PRETTY_PRINT));
		}
?>