<?php

// James Zatsiorsky
// January 14, 2015
// Add profile picture to database

// configuration
require("../includes/config.php");

$url = $_POST["url"];

// if user is a player
if ($_SESSION["ref"] == 0) {
	query("UPDATE users SET photo = ? WHERE userid = ?", $url, $_SESSION["id"]);
}
// else user is a ref
else {
	query("UPDATE refs SET photo = ? WHERE refid = ?", $url, $_SESSION["id"]);
}

$_SESSION["photo"] = $url;

?>