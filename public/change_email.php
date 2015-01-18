<?php
    
    // configuration
    require("../includes/config.php");
    
    
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // render form to manage account
        render("manage_account_form.php", ["title" => "Manage Account"]);
    }
    
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $rows = query("SELECT * FROM users WHERE userid = ?", $_SESSION["id"]);
        
        // empty field
        if (empty($_POST["new_email1"]) || empty($_POST["new_email2"]))
        {
            apologize("Make sure you fill in all fields.");
        }
        
        // correct current password, and new passwords match
        else if ($_POST["new_email1"] == $_POST["new_email2"])
        {
            if (query("UPDATE users SET email = ? WHERE userid = ?", $_POST["new_email1"], $_SESSION["id"]) === false)
	   	 	{
				apologize("That e-mail address may already be taken. Please try again.");
			}

            // reload account management page and show success
            render("manage_account_form.php", ["success" => "email"]);
        }
        else
        {   
            apologize("Error resetting your e-mail. Please try again.");
        }
        
    }
?>
