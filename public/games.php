<?php

    // configuration
    require("../includes/config.php"); 

    // player account
    if ($_SESSION["ref"] == 0) {
    	if (($rows = query("SELECT sport FROM games WHERE (team1 = ? OR team2 = ?) AND result = 0 AND date >= CURDATE()", $_SESSION["house"], $_SESSION["house"])) == false)
			apologize("Your house has no upcoming games!");
	}
	// not a player account
	else {
		if (($rows = query("SELECT sport FROM games WHERE result = 0 AND date >= CURDATE()")) == false)
			apologize("There are no upcoming games!");
	}

	// create an array of sports
	for ($i = 0, $n = count($rows); $i < $n; $i++) 
	{
	    $buffer[$i] = $rows[$i]["sport"]; 
	}
	$sports = array_unique($buffer);

	// alphabetize array
	sort($sports);
	
	// render form
	render("games_form.php", ["title" => "Games", "sports" => $sports]);  
	
?>
