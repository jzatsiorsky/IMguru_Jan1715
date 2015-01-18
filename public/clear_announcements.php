<?php

// James Zatsiorsky
// January 14, 2015
// Script that clears a player's announcements

// configuration
require("../includes/config.php");

// if the user is a player
if ($_SESSION["ref"] == 0) {
	query("DELETE FROM myannouncements WHERE userid = ?", $_SESSION["id"]);
}
// else the user is a ref
else {
	apologize("This function is only for players.");
}




?>