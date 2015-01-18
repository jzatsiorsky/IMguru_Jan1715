<?php

 // configuration
 require("../includes/config.php");

 // set the timezone
query("SET time_zone = 'America/New_York'");
// choose all games that are on the current day and that are occuring an hour (between 55 and 65 min) after the current time
$rows = query("SELECT * FROM games WHERE date = CURDATE() AND time > ADDTIME(CURTIME(), '00:55:00') AND time < ADDTIME(CURTIME(), '01:05:00')");

// do the following for each game that is one hour in the future
foreach ($rows as $row)
{
	// get all of the e-mails of the users who are playing the game
	$players = query("SELECT * FROM rosters INNER JOIN games ON rosters.gameid = games.gameid WHERE rosters.gameid = ?", $row["gameid"]);

	// do the following for each e-mail address
	foreach($players as $player)
	{
		// get the user's first name for the e-mail
		$explode = explode(" ", $player["name"]);
		$firstName = $explode[0];
		$to = $player["email"];
		$subject = 'Upcoming ' . $player["sport"] . ' Game';
		$message = 'Dear ' . $firstName . ',' . "\r\n\r\n" . 'This is a reminder that you have signed up for an intramural game occuring in one hour. ';
		$message .= 'Best of luck!' . "\r\n\r\n";
		$message .= 'Sport: ' . $player["sport"] . "\r\n";
		$message .= 'Location: ' . $player["location"] . "\r\n";
		$message .= 'Time: ' . date_format(date_create($player["time"]), "g:i a");
		$message .= "\r\n\r\n" . 'Go ' . $player["house"] . '!' . "\r\n\r\n"  . 'The IMguru Team';
		$headers = 'From: register@imharvard.com' . "\r\n" .
		'Reply-To: register@imharvard.com' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);
	}
}

?>