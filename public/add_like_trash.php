<?php
    
    // configuration
    require("../includes/config.php");
    
    
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
	return false;
    }
    
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
		if (empty($_POST["messageid"]) == TRUE)
		{
			exit;
		}
		
		// joint primary key of userid and messageid, so that user can only like each post once
		if (query("INSERT INTO trashlikes (userid, messageid) VALUES (?, ?)", $_SESSION["id"], $_POST["messageid"]) === false)
		{
			exit;
		}
		
		query("UPDATE trashtalk SET likes = (likes + 1) WHERE messageid = ?", $_POST["messageid"]); 
		
	}
	
	

?>
