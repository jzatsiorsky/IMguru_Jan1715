<?php
    
    // configuration
    require("../includes/config.php");
    
    
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
		// referee account
		if ($_SESSION["ref"] == 1)
		{
			// get all games that have occurred in the past
			if (($games = query("SELECT * FROM games WHERE result = 0 AND date <= CURDATE() ORDER BY date, time DESC")) == false)
				apologize("All games have been submitted.");
    		// render form
   	 		render("submit_result_form.php", ["title" => "Submit Result", "games" => $games]);
		}
		// not a referee account
		else 
		{
			if ($_SESSION["captain"] == 1)
			{
				// get all games that the user's house is in that have occurred in the past
				if (($games = query("SELECT * FROM games WHERE (team1 = ? OR team2 = ?) AND result = 0 AND date <= CURDATE() ORDER BY date DESC", $_SESSION["house"], $_SESSION["house"])) == false)
					apologize("All games have been submitted.");
        		// render form
       	 		render("submit_result_form.php", ["title" => "Submit Result", "games" => $games]);
			}
			else
			{
				apologize("You don't have privileges to view this page.");
			}
		}
    }
    
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
    	// apologize if empty fields
    	if (!isset($_POST["forfeit"]) && !isset($_POST["team1score"]) && !isset($_POST["team2score"])) {
    		apologize("No fields completed.");
    	}

    	// pull out the info for submitted game
    	if (($gameinfos = query("SELECT * FROM games WHERE gameid = ?", $_POST["gameid"])) === false)
    	{
    		apologize("Sorry, this game does not exist.");
    	}

    	$gameinfo = $gameinfos[0];
    	
    	// the game was a forfeit 
    	if (isset($_POST["forfeit"])) {
    		switch ($_POST["forfeit"]) {
    			case "team1forfeit":
    				if (query("UPDATE games SET team1score = 0, team2score = 0, result = TRUE, forfeit = 1, team1forfeit = 1, team2forfeit = 0 WHERE gameid = ?", $_POST["gameid"]) === true)
					{
						query("UPDATE standings SET wins = (wins + 1) WHERE house = ? AND sport = ?", $gameinfo["team2"], $gameinfo["sport"]);
						query("UPDATE standings SET forfeits = (forfeits + 1) WHERE house = ? AND sport = ?", $gameinfo["team1"], $gameinfo["sport"]);
					}
					else
					{
						apologize("Error submitting result.");
					}
					break;
    			case "team2forfeit":
    				if (query("UPDATE games SET team1score = 0, team2score = 0, result = TRUE, forfeit = 1, team1forfeit = 0, team2forfeit = 1 WHERE gameid = ?", $_POST["gameid"]) === true)
					{
						query("UPDATE standings SET wins = (wins + 1) WHERE house = ? AND sport = ?", $gameinfo["team1"], $gameinfo["sport"]);
						query("UPDATE standings SET forfeits = (forfeits + 1) WHERE house = ? AND sport = ?", $gameinfo["team2"], $gameinfo["sport"]);
					}
					else
					{
						apologize("Error submitting result.");
					}
					break;
    			case "both";
    				if (query("UPDATE games SET team1score = 0, team2score = 0, result = TRUE, forfeit = 1, team1forfeit = 1, team2forfeit = 1 WHERE gameid = ?", $_POST["gameid"]) === true)
					{
						query("UPDATE standings SET forfeits = (forfeits + 1) WHERE house = ? AND sport = ?", $gameinfo["team2"], $gameinfo["sport"]);
						query("UPDATE standings SET forfeits = (forfeits + 1) WHERE house = ? AND sport = ?", $gameinfo["team1"], $gameinfo["sport"]);
					}
					else
					{
						apologize("Error submitting result.");
					}
					break;
				default:
					apologize("Error. Please try again.");
    		}
    	}
    	else {
			// apologize if empty field
	        if (is_blank($_POST["team1score"]) || is_blank($_POST["team2score"]))
	        {
	            apologize("Make sure you fill in all fields.");
	        }

			$team1score = $_POST["team1score"];
			$team2score = $_POST["team2score"];
			
		    // insert result into table
		    if (query("UPDATE games SET team1score = ?, team2score = ?, result = TRUE WHERE gameid = ?", $team1score, $team2score, $_POST["gameid"]) === false)
			{
				apologize("Error submitting result.");
			}

			if ($team1score > $team2score)
			{
				query("UPDATE standings SET wins = (wins + 1) WHERE house = ? AND sport = ?", $gameinfo["team1"], $gameinfo["sport"]);
				query("UPDATE standings SET losses = (losses + 1) WHERE house = ? AND sport = ?", $gameinfo["team2"], $gameinfo["sport"]);
			}
			elseif ($team1score < $team2score)
			{
				query("UPDATE standings SET wins = (wins + 1) WHERE house = ? AND sport = ?", $gameinfo["team2"], $gameinfo["sport"]);
				query("UPDATE standings SET losses = (losses + 1) WHERE house = ? AND sport = ?", $gameinfo["team1"], $gameinfo["sport"]);
			}
			elseif ($team1score == $team2score)
			{
				query("UPDATE standings SET ties = (ties + 1) WHERE house = ? AND sport = ?", $gameinfo["team1"], $gameinfo["sport"]);
				query("UPDATE standings SET ties = (ties + 1) WHERE house = ? AND sport = ?", $gameinfo["team2"], $gameinfo["sport"]);
			}
		}

		// return to home page
	    redirect("/");
		
    }

// http://php.net/manual/en/function.empty.php steven@nevvix.com 
function is_blank($value) {
    return empty($value) && !is_numeric($value);
}
?>
