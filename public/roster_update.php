<?php

    require(__DIR__ . "/../includes/config.php");
	
	// if the user is not already attending, add them into the roster table for that game
	if ($_POST["attending"] == 0)
	{
		if ($_SESSION["ref"] == 0)
			query("INSERT INTO mygames(userid, gameid) VALUES(?, ?)", $_SESSION["id"], $_POST["gameid"]);
		else
			query("INSERT INTO refgames(refid, gameid) VALUES(?, ?)", $_SESSION["id"], $_POST["gameid"]);
	}
	else if ($_POST["attending"] == 1)
	{
		if ($_SESSION["ref"] == 0)
			query("DELETE FROM mygames WHERE gameid = ? AND userid = ?", $_POST["gameid"], $_SESSION["id"]);
		else
			query("DELETE FROM refgames WHERE gameid = ? AND refid = ?", $_POST["gameid"], $_SESSION["id"]);
	}
?>
