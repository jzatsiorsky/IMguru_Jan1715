<?php
    
    // configuration
    require("../includes/config.php");
    
    
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // render form
        render("huddle_form.php", ["title" => "The Huddle"]);
    }
    
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
		if (empty($_POST["message"]) == TRUE || empty($_POST["sport"]) == TRUE)
		{
			return false;
		}
        query("SET time_zone = 'America/New_York'");
		query("INSERT INTO huddle (userid, house, sport, message, date_time) VALUES (?, ?, ?, ?, DATE_FORMAT(CURRENT_TIMESTAMP(),'%b %e at %l:%i %p'))", $_SESSION["id"], $_SESSION["house"], $_POST["sport"], $_POST["message"]); 
		return true;

	}
	
	

?>
