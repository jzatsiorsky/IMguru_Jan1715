<?php
    
    // configuration
    require("../includes/config.php");
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
    	if ($_SESSION["ref"] == 0)
    		$url = query("SELECT * FROM users WHERE userid = ?", $_SESSION["id"]);
    	else
    		$url = query("SELECT * FROM refs WHERE refid = ?", $_SESSION["id"]);

        // render form
        render("manage_account_form.php", ["title" => "Manage Account", "url" => $url[0]["photo"]]);
    }

    

?>
