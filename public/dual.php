<?php

    // configuration
    require("../includes/config.php"); 

    if ($_SESSION["dual"] == 1) {
    	if ($_SESSION["ref"] == 0) 
        {
            $row = query("SELECT * FROM users WHERE userid = ?", $_SESSION["id"]);
            $username = $row[0]["username"];
            $change = query("SELECT * FROM refs WHERE username = ?", $username);
            $_SESSION["id"] = $change[0]["refid"];
    		$_SESSION["ref"] = 1;
            $_SESSION["photo"] = $change[0]["photo"];
        }

    	else
        {
            $row = query("SELECT * FROM refs WHERE refid = ?", $_SESSION["id"]);
            $username = $row[0]["username"];
            $change = query("SELECT * FROM users WHERE username = ?", $username);
            $_SESSION["id"] = $change[0]["userid"];
            $_SESSION["ref"] = 0;
            $_SESSION["photo"] = $change[0]["photo"];
        }

    }
    else
    {
    	apologize("You do not have a dual account.");
    }

    // go to the home page
    redirect("/");
?> 