<?php
    
    // configuration
    require("../includes/config.php");
    
    
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {	
		// CHECK IF USER IS AUTHORIZED TO SEE THIS TRASH TALK THREAD
		if (empty($_GET["gameid"]))
			apologize("You need to submit a gameid.");

		// check if game exists
		if (($teams = query("SELECT * FROM games WHERE gameid = ?", $_GET["gameid"])) == false)
			apologize("That game does not exist.");
		
        // render form
        render("trashtalk_form.php", ["title" => "Trash Talk", "teams" => $teams ]);
    }
    
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
		if (empty($_POST["message"]))
		{
			return false;
		}
		query("INSERT INTO trashtalk (userid, gameid, message, date_time) VALUES (?, ?, ?, DATE_FORMAT(NOW(),'%d %b %Y %r'))", $_SESSION["id"], $_POST["gameid"], $_POST["message"]); 
		return true;

	}
	
	

?>
