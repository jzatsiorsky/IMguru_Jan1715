<?php
    
    // configuration
    require("../includes/config.php");
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
	// render form
        render("manage_account_form.php", ["title" => "Manage Account"]);
    }
    
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $rows = query("SELECT * FROM users WHERE userid = ?", $_SESSION["id"]);
        
        // empty field
        if (empty($_POST["captainpassword"]))
        {
            apologize("You left the password blank.");
        }
        
        // correct current password, and new passwords match
        else if ($_POST["captainpassword"] == CAPTAIN)
        {
            query("UPDATE users SET captain = 1 WHERE userid = ?", $_SESSION["id"]);
			// store captain status in SESSION
			$_SESSION["captain"] = 1;
            // reload account management page and show success 
            render("manage_account_form.php", ["success" => "captain"]);
        }
        else
        {   
            apologize("Incorrect captain password.");
        }
        
    }
?>
