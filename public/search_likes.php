<?php

    require(__DIR__ . "/../includes/config.php");
	
	if (empty($_GET["messageid"]) == TRUE)
	{
		return false;   
	}
    // numerically indexed array of messages matching sport
    $likes = [];

    $likes = query("SELECT * FROM huddle WHERE messageid = ?", $_GET["messageid"]);

    // output places as JSON (pretty-printed for debugging convenience)
    header("Content-type: application/json");
    print(json_encode($likes, JSON_PRETTY_PRINT));

?>
