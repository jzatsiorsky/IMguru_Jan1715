<?php

    require(__DIR__ . "/../includes/config.php");
	
	if (empty($_GET["gameid"]))
	{
		return false;   
	}
    // get each message from the two houses for the given gameid
    $messages = query("SELECT * FROM trashtalk INNER JOIN users ON trashtalk.userid=users.userid WHERE (users.house = ? OR users.house = ?) AND trashtalk.gameid = ?", $_GET["house1"], $_GET["house2"], $_GET["gameid"]);

    // output places as JSON (pretty-printed for debugging convenience)
    header("Content-type: application/json");
    print(json_encode($messages, JSON_PRETTY_PRINT));

?>
