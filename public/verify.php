<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // if for some reason there is no random username in URL, spit out error
        if (!isset($_GET["user"]))
            apologize("I think you are lost.");

        // get the username by exploding the e-mail
        if (($row = query("SELECT * FROM users WHERE username = ?", $_GET["user"])) === false)
            apologize("Error verifying your account.");
        if ($row == false)
            redirect("../login.php");
        
        $email = $row[0]["email"];
        $explode = explode("@", $email);
        // this is the real username
        $user = $explode[0];

        // replace the random username with the real username (which is the e-mail address)
        if (query("UPDATE users SET username = ? WHERE username = ?", $email, $_GET["user"]) === false)
            apologize("Error verifying account. Please e-mail us at register@imharvard.com for assistance.");


        // complete registration and log in

        $id = $row[0]["userid"];
        $house = $row[0]["house"];
        $name = $row[0]["name"];
        $captain = $row[0]["captain"];
      
        
        $_SESSION["id"] = $id;               
        $_SESSION["house"] = $house;
        $_SESSION["name"] = $name;
        $_SESSION["captain"] = $captain;
        $_SESSION["ref"] = 0;
        // check if the account is a dual account
        $dual = query("SELECT * FROM refs WHERE LOWER(username) = ?", $email);
        if (count($dual) == 1)
            $_SESSION["dual"] = 1;
        else
            $_SESSION["dual"] = 0;

        
        // log the user in
        redirect("../index.php");

    }
?>
