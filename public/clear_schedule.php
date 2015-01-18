<?php

// James Zatsiorsky
// January 14, 2015
// Script that clears a player or ref's schedule

// configuration
require("../includes/config.php");

// if the user is a player
if ($_SESSION["ref"] == 0) {
	query("DELETE FROM mygames WHERE userid = ?", $_SESSION["id"]);
}
// else the user is a ref
else {
	query("DELETE FROM refgames WHERE refid = ?", $_SESSION["id"]);
}




?>