<?php

    require(__DIR__ . "/../includes/config.php");
	
    // make sure there is a gameid
	if (empty($_GET["gameid"])) 
		return false;   

    // if player account, make sure there is house
    if ($_SESSION["ref"] == 0)
    {
        if (empty($_GET["house"]))
            return false;
    }
    
    // numerically indexed array of players matching gameid and house

    if ($_SESSION["ref"] == 0)
        $roster = query("SELECT * FROM mygames INNER JOIN users ON mygames.userid = users.userid WHERE gameid = ? AND house = ?", $_GET["gameid"], $_GET["house"]);
    
    else
        $roster = query("SELECT * FROM refgames INNER JOIN refs ON refgames.refid = refs.refid WHERE gameid = ?", $_GET["gameid"]);
    
    // output places as JSON (pretty-printed for debugging convenience)
    header("Content-type: application/json");
    print(json_encode($roster, JSON_PRETTY_PRINT));

?>
