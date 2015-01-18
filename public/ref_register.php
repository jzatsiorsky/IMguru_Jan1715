<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("ref_register_form.php", ["title" => "Ref Register"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["email"]) || empty($_POST["first_name"]) || empty($_POST["last_name"]) || empty($_POST["password"]) || empty($_POST["confirmation"]) || empty($_POST["ref_password"]))
        {
            apologize("Please make sure you fill out all fields.");
        }
        else if ($_POST["password"] != $_POST["confirmation"])
        {
            apologize("Please ensure that the passwords you entered matched.");
        }
        else if ($_POST["ref_password"] != REFEREE)
        {
            apologize("The referee password you entered was incorrect.");
        }
        else
        {
        	// generate random username
		    // http://stackoverflow.com/questions/4356289/php-random-string-generator
		    $length = 15;
			$randomUser = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
			
            // check to see if that username is taken
            $rows = query("SELECT * FROM refs WHERE username = ?", $_POST["email"] . "@" . $_POST["school"] . ".harvard.edu");
            if (count($rows) != 0)
                apologize("That username is already taken.");

            // error registering
            if (query("INSERT INTO refs (username, email, password, name) VALUES (?, ?, ?, ?)", $randomUser, $_POST["email"] . "@" . $_POST["school"] . ".harvard.edu", crypt($_POST["password"]), ucwords($_POST["first_name"])." ".ucwords($_POST["last_name"])) === false)
            {
                apologize("There was an error registering your account. Try using a different username.");
            }
            else
            {
	        	// send e-mail to verify account
	        	$to = $_POST["email"] . "@" . $_POST["school"] . ".harvard.edu";
				$subject = 'IMguru Registration';
				$message = 'Dear ' . ucwords($_POST["first_name"]) . ',' . "\r\n\r\n" . 'Thank you for requesting refree registration with IMguru! We look forward to helping you run Harvard intramurals.' . "\r\n";
				$message .= 'To complete your registration, please visit: imharvard.com/ref_verify.php?user=' . $randomUser . "\r\n\r\n";
				$message .= 'If you did not initiate this e-mail, you can ignore it! ';
				$message .= "\r\n\r\n" . 'Go Crimson!' . "\r\n\r\n"  . 'The IMguru Team';
				$headers = 'From: register@imharvard.com' . "\r\n" .
			    'Reply-To: register@imharvard.com' . "\r\n" .
			    'X-Mailer: PHP/' . phpversion();
			    if (!mail($to, $subject, $message, $headers))
			    	apologize("That e-mail account may not be valid.");
			    }
                render("verify_form.php", ["title" => "Verify e-mail"]);
        }
    }
    

?>
