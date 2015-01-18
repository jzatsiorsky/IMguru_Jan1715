<?php

	// configuration
	require("../includes/config.php");

	// make sure user is a ref or captain
	if ($_SESSION["captain"] == 0)
	{
		return false;
	}

	// make sure there is info for gameid, house, and the email message
	if (empty($_POST["message"]) || empty($_POST["gameid"]) || empty($_POST["house"]))
	{
		return false;
	}
		
	else
	{
		query("START TRANSACTION");

        // add the announcement to the announcement database
//        query("INSERT INTO announcements (announcementtext) VALUES (?)", $announcement);

        // get the id of the last announcement
//        $announcementid = query("SELECT LAST_INSERT_ID()");
//        $announcementid = $announcementid[0]["LAST_INSERT_ID()"];

		// get emails for users attending game
        $users = query("SELECT name, email FROM mygames INNER JOIN users ON mygames.userid = users.userid WHERE gameid = ? AND house = ?", $_POST["gameid"], $_POST["house"]);

		// get info about game
		$gameinfo = query("SELECT * FROM games WHERE gameid = ?", $_POST["gameid"]);
		$sport = $gameinfo[0]["sport"];
		$date = $gameinfo[0]["date"];
		$announcement = $_POST["message"];
		query("COMMIT");
		$captainname = $_SESSION["name"];

		if($_POST["house"] == $gameinfo[0]["team1"])
		{
			$opponent = $gameinfo[0]["team2"];
		}
		else
		{
			$opponent = $gameinfo[0]["team1"];
		}

		foreach ($users as $user)
		{
			            // insert the announcement into myannouncements
//            query("INSERT INTO myannouncements(announcementid, userid) VALUES (?, ?)", $announcementid, $user["userid"]);

            // send an e-mail
            $to = $user["email"];
            $subject = 'ANNOUNCEMENT from captain about upcoming ' . $sport . ' game on ' . $date;
            $message = 'Dear ' . $user["name"] . ',' . "\r\n\r\n" . 'Your captain, ' . $captainname . ' has made';
            $message .= ' an announcement about your upcoming ' . $sport . ' game against ' . $opponent . ':' . "\r\n\r\n";
            $message .= $announcement . "\r\n\r\n";
            $message .= 'You recieved this email because you have indicated that you will be attending this game. ';
            $message .= 'To learn more about this game, or if you can no longer make it, visit imharvard.com/game_page.php?gameid=' . $_POST["gameid"] . "\r\n\r\n" ;
            $message .='Go ' . $_POST["house"] . '!' . "\r\n\r\n"  . 'The IMguru Team';
            $headers = 'From: register@imharvard.com' . "\r\n" . 'Reply-To: register@imharvard.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
            if (!mail($to, $subject, $message, $headers))
                apologize("That e-mail account may not be valid.");
        }

	}
?>