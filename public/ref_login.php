<?php

    // configuration
    require("../includes/config.php"); 

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("ref_login_form.php", ["title" => "Ref Log In"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["username"]))
        {
            apologize("You must provide your user name.");
        }
        else if (empty($_POST["password"]))
        {
            apologize("You must provide your password.");
        }

        // query database for user
        // username is case insensitive
        $rows = query("SELECT * FROM users WHERE LOWER(username) = ?", strtolower($_POST["username"]) . "@" . $_POST["school"] . ".harvard.edu");

        // if we found user, check password
        if (count($rows) == 1)
        {
            // first (and only) row
            $row = $rows[0];

            // compare hash of user's input against hash that's in database
            if (crypt($_POST["password"], $row["password"]) == $row["password"])
            {
                // remember that user's now logged in by storing user's ID in session
                $_SESSION["id"] = $row["userid"];
		        $_SESSION["house"] = $row["house"];
		        $_SESSION["name"] = $row["name"];
		        $_SESSION["captain"] = $row["captain"];
                
                // check if the account is a dual account
                $dual = query("SELECT * FROM users WHERE LOWER(username) = ?", strtolower($_POST["username"]) . "@" . $_POST["school"] . ".harvard.edu");
                if (count($dual) == 1)
                    $_SESSION["dual"] = 1;
                else
                    $_SESSION["dual"] = 0;

                $_SESSION["id"] = hi;

                // redirect to portfolio
                redirect("/");
            }
        }

        // else apologize
        apologize("Invalid username and/or password.");
    }

?>
