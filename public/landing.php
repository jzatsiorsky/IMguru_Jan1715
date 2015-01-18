<?php

    // configuration
    require("../includes/config.php"); 
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // render template
        require("../templates/landing_page.php");
    }
    else {
    	if (!empty($_POST["email"])) {
    		query("INSERT INTO mailinglist (email) VALUES (?)", $_POST["email"]);
    	}

    	redirect("/");
        
    }
    
?>                                          
