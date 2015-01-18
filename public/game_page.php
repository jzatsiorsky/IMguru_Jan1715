<?php

    // configuration
    require("../includes/config.php"); 
    if (empty($_GET["gameid"]))
    {
        apologize("No games to found here!");
    }
    
    
    // pull out the info for the game
    $gameinfo = query("SELECT * FROM games WHERE gameid = ?", $_GET["gameid"]);

	if (empty($gameinfo))
    {
        apologize("Sorry, there is currently no information about this game.");
    }

    $location = query("SELECT * FROM venues WHERE name = ?", $gameinfo[0]["location"]);


    // if player account, make sure user is involved in game
    if ($_SESSION["ref"] == 0) {
        // make sure the user's house is participating in the game
        if ($_SESSION["house"] != $gameinfo[0]["team1"] && $_SESSION["house"] != $gameinfo[0]["team2"])
        {
            apologize("Sorry! Your house is not participating in this game.");
        }
        // see if the user has already signed up for the game
        $check = query("SELECT * FROM mygames WHERE gameid = ? AND userid = ?", $_GET["gameid"], $_SESSION["id"]);
    }
    // referee account
    else
        $check = query("SELECT * FROM refgames WHERE gameid = ? AND refid = ?", $_GET["gameid"], $_SESSION["id"]);
    
    
    if (empty($check))
    {
        $attending = 0;
    }
    else
    {
        $attending = 1;
    }

    // if captain, see if anyone from the house has signed up for the game
    $roster = false;
    if ($_SESSION["captain"] == 1)
    {
        $check = query("SELECT * FROM mygames INNER JOIN users ON mygames.userid = users.userid WHERE gameid = ? AND house = ?", $_GET["gameid"], $_SESSION["house"]);
        if (!empty($check))
        {
            $roster = true;
        }
    }

	
    render("future_game.php", ["gameinfo" => $gameinfo[0], "location" => $location[0], "attending" => $attending, "roster" => $roster]);
    
?>                                          
