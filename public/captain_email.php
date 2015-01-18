<?php
	
	// configuration
	require("../includes/config.php");

	if ($_SESSION["captain"] == 0)
	{
		apologize("You have to be a captain to use this page.");
	}

	$sports = query("SELECT sport FROM mysports INNER JOIN users ON mysports.userid = users.userid WHERE house = ?", $_SESSION["house"]);
	$lists = [];

	foreach ($sports as $sport)
	{
		array_push($lists, $sport["sport"]);
	}
	$lists = array_unique($lists);

	if ($_SERVER["REQUEST_METHOD"] == "GET")
	{
		
		render("captain_email_form.php", ["lists" => $lists]);

	}
	elseif ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		query("START TRANSACTION");

		// get emails for users attending game
        $users = query("SELECT * FROM users INNER JOIN mysports ON users.userid = mysports.userid WHERE house = ? AND sport = ?", $_SESSION["house"], $_POST["sport"]);

		// info for email
        $sport = $_POST["sport"];
		$announcement = $_POST["announcement"];
		query("COMMIT");
		$captainname = $_SESSION["name"];
		$house = $_SESSION["house"];


		foreach ($users as $user)
		{
			            // insert the announcement into myannouncements
//            query("INSERT INTO myannouncements(announcementid, userid) VALUES (?, ?)", $announcementid, $user["userid"]);

            // send an e-mail
            $to = $user["email"];
            $subject = 'ANNOUNCEMENT from ' . $house . '\'s '. $sport . ' captain';
            $message = 'Dear ' . $user["name"] . ',' . "\r\n\r\n" . 'Your captain, ' . $captainname . ' has made';
            $message .= ' an announcement to everyone in your ' . $sport . ' league:' . "\r\n\r\n";
            $message .= $announcement . "\r\n\r\n";
            $message .= 'You recieved this email because you have subscribed to the email list for your house\'s ' . $sport . ' league. ';
            $message .= 'If you want to unsubscribe from this list, visit imharvard.com/league_signup.php to change your preferences.' . "\r\n\r\n" ;
            $message .='Go ' . $house . '!' . "\r\n\r\n"  . 'The IMguru Team';
            $headers = 'From: register@imharvard.com' . "\r\n" . 'Reply-To: register@imharvard.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
            if (!mail($to, $subject, $message, $headers))
                apologize("That e-mail account may not be valid.");
        }

        $success = "true";
        render("captain_email_form.php", ["lists" => $lists, "success" => $success]);
	}

?>