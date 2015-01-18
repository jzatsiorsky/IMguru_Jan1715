<?php
    
    // configuration
    require("../includes/config.php");
    
    if ($_SESSION["ref"] == 0) {
    	apologize("You are not logged into a referee account.");
    }
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // render form
        render("announcement_form.php", ["title" => "Announcement"]);
    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $announcement = $_POST["announcement"];
        // check that the announcement is not empty
        if (empty($announcement)) 
            apologize("The announcement cannot be empty.");

        $recipients = $_POST["announcementTo1"];
        $location = $_POST["announcementTo2"];
        $location2 = $_POST["announcementTo3"];

        // Begin transaction
        query("START TRANSACTION");

        // add the announcement to the announcement database
        query("INSERT INTO announcements (announcementtext, refid) VALUES (?, ?)", $announcement, $_SESSION["id"]);

        // get the id of the last announcement
        $announcementid = query("SELECT LAST_INSERT_ID()");
        $announcementid = $announcementid[0]["LAST_INSERT_ID()"];

        // now assign the announcement to the people it is designated to

        // get the proper recipients
        if ($recipients == "allPlayers") {
            // check the house
            if ($location == "allHouses")
                $users = query("SELECT * FROM users");
            else if (empty($location2))
                $users = query("SELECT * FROM users WHERE house = ?", $location);
            else
                $users = query("SELECT * FROM users WHERE house = ? OR house = ?", $location, $location2);
        }
        else {
            // check the house
            if ($location == "allHouses")
                $users = query("SELECT * FROM users WHERE captain = 1");
            else if (empty($location2))
                $users = query("SELECT * FROM users WHERE captain = 1 AND house = ?", $location);
            else
                $users = query("SELECT * FROM users WHERE captain = 1 AND (house = ? OR house = ?)", $location, $location2);
        }

        // get a small version of the photo
        $photo = explode("200x200", $_SESSION["photo"])[0];
        $photo .= "50x50/";

        // all of the users that the announcement belongs to are stored in $users

        foreach ($users as $user) {
            // insert the announcement into myannouncements
            query("INSERT INTO myannouncements (announcementid, userid) VALUES (?, ?)", $announcementid, $user["userid"]);

            // get first name
            $first = explode(" ", $user["name"])[0];

            // send an e-mail
            $to = $user["email"];
            $subject = "Referee Announcement";
            $message = '<html><body>';
            $message .='Dear ' . $first . ',' . "<br><br>" . 'A referee has made an announcement relevant to your house:' . "<br><br>";
            $message .= "\"" . $announcement . "\"" .  "<br><br>";
            $message .= "Announcement sent by " . $_SESSION["name"] . "<br>";
            $message .= "<img src='" . $photo . "' style='border-radius: 25px; display: inline;' /></body></html>";
            $headers = 'From: register@imharvard.com' . "\r\n" .
            'Reply-To: register@imharvard.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion() . "\r\n" .
            'Content-type: text/html';
            if (!mail($to, $subject, $message, $headers))
                apologize("That e-mail account may not be valid.");
        }

        // submit 
        query("COMMIT");

        // reload the page
        render("announcement_form.php", ["title" => "Announcement", "success" => 1]);
    }
    


?>
