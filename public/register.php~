<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("register_form.php", ["title" => "Register"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["email"]) || empty($_POST["first_name"]) || empty($_POST["last_name"]) || empty($_POST["house"]) || empty($_POST["year"]) || empty($_POST["password"]) || empty($_POST["confirmation"]))
        {
            apologize("Please make sure you fill out all fields.");
        }
		else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
		{
			apologize("The e-mail address you entered is not valid.");
		}
        else if ($_POST["password"] != $_POST["confirmation"])
        {
            apologize("Please ensure that the passwords you entered matched.");
        }
		else if ($_POST["captain"] == "1" && $_POST["captainpassword"] != CAPTAIN)
		{
			apologize("Incorrect captain password.");
		}
        else
        {
            // error registering
            if (query("INSERT INTO users (email, password, house, captain, year, name) VALUES (?, ?, ?, ?, ?, ?)", $_POST["email"], crypt($_POST["password"]), $_POST["house"], $_POST["captain"], $_POST["year"], $_POST["first_name"]." ".$_POST["last_name"]) === false)
            {
                apologize("There was an error registering your account. Try using a different username.");
            }
            
            // successful registration
            else
            {
                $rows = query("SELECT LAST_INSERT_ID() AS userid");
                $id = $rows[0]["userid"];
				
                $_SESSION["id"] = $id;               
				$_SESSION["house"] = $_POST["house"];
				$_SESSION["name"] = $_POST["first_name"] . " " . $_POST["last_name"];
				$_SESSION["captain"] = $_POST["captain"];
                
                // log the user in
                redirect("../index.php");
            }

        }
    }
    

?>
