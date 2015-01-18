<?php
    
    // configuration
    require("../includes/config.php");
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
		// referee account
		if ($_SESSION["ref"] == 1)
		{
			$rows = query("SELECT name FROM venues");
	        for($i = 0, $n = count($rows); $i < $n; $i++) 
			{
			    $buffer[$i] = $rows[$i]["name"]; 
			}
			$venues = array_unique($buffer);
    		// render form
   	 		render("create_schedule_form.php", ["title" => "Create Schedule", "venues" => $venues]);
		}
		// not a referee account
		else 
		{
			apologize("You don't have privileges to view this page.");
			
		}
    }
    
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
    	if (empty($_POST["sport"])) {
    		apologize("You must submit a sport.");
    	}

		$sport = $_POST["sport"];

		$data = "<br><br>" . "SCHEDULE FOR " . strtoupper($sport);
	   	$allTeams = ["Adams", "Cabot", "Currier", "Dudley", "Dunster", "Eliot", "Kirkland", "Leverett", "Lowell", "Mather", "Pforzheimer", "Quincy", "Winthrop"];
	   	$teams = [];
	   	foreach ($allTeams as $team) {
	   		if (isset($_POST[$team])) {
	   			array_push($teams, $team);
	   		}
	   	}
	   	shuffle($teams);
	   	$count = count($teams);
	   	if ($count % 2 == 1) {
	   		array_push($teams, "bye");
	   		$count++;
	   	}

	   	$numGamesPerWeek = count($teams) / 2;

	   	if (empty($startDate)) {
	   		apologize("You must submit a start date.");
	   	}
	   	$startDate = $_POST["startDate"];
	   	
		$gamesPerSeason = $_POST["gamesPerSeason"];
		$dets = [];
		for ($i = 0; $i < 6; $i++) {
			if (empty($_POST["time".($i+1)]) || empty($_POST["location".($i+1)]) || empty($_POST["day".($i+1)])) {
				apologize("You must submit all times, locations, and venues.");
			}
			$detail = $_POST["time".($i+1)] . "/" . $_POST["location".($i+1)] . "/" . $_POST["day".($i+1)];
			array_push($dets, $detail);
		}

		// dets will change, so back it up
		$originalDets = $dets;
	   			
	   	$data .="<br>";
	   	query("START TRANSACTION");
	   	for ($j = 0; $j < $gamesPerSeason; $j++) {
	   		$data .="<br>" . "WEEK " . ($j+1) . "<br><br>";
		   	for ($i = 0; $i < $numGamesPerWeek; $i++) {
		   		$data .=($i+1) . ". ";
		   		$details = $dets[$i];

				$explode = explode("/", $details);
	   			$time = $time = date("H:i:s", strtotime( $explode[0]));
	   			$location = $explode[1];
	   			$day = $explode[2];
	   			$day = date("N", strtotime($day));
	   			$startDateNum = date("N", strtotime($startDate));
	   			$offset = $day - $startDateNum;
	   			$team1 = $teams[$i];
	   			$team2 = $teams[$count - 1 - $i];
	   			$date = date("Y-m-d", strtotime($startDate) + (60*60*24*7*$j + 60*60*24*$offset));
	   			if ($team1 == "bye") {
	   				$data .= $team2 . " has a bye." . "<br>";
	   			}
	   			else if ($team2 == "bye") {
	   				$data .= $team1 . " has a bye." . "<br>";
	   			}
	   			else {
		   			$data .= $team1 . " plays " . $team2 . " at " . $time . " on " . $date . " at " . $location . "<br>";
		   		}

		   		// insert a game into the database only if the game is not a bye
		   		if ($team1 != "bye" && $team2 != "bye") {	
			   		if (query("INSERT INTO games(sport, date, time, location, details, team1, team2) VALUES(?, ?, ?, ?, ?, ?, ?)", $sport, $date, $time, $location, "", $team1, $team2) === false)
			        {
			            apologize("Sorry, there was an error trying to schedule your game.");
			        }
			        // get the gameid for the game just scheduled
			        $gameid = query("SELECT LAST_INSERT_ID() FROM games LIMIT 1");
			        // add all the players signed up to be added to rosters for that sport in mysports to the roster for the game
			        $players = query("SELECT * FROM mysports INNER JOIN users ON mysports.userid = users.userid WHERE sport = ? AND pref = 'all' AND (house = ? OR house = ?)", $_POST["sport"], $_POST["team1"], $_POST["team2"]);
			        foreach ($players as $player)
			        {
			            query("INSERT INTO mygames (userid, gameid) VALUES(?, ?)", $player["userid"], $gameid[0]["LAST_INSERT_ID()"]);
			        }
			    }
			    else {
				    // if the game is a bye, do not put the game into the database, and adjust the dets array
				    array_splice($dets, $i, 0, $dets[$i]);
				}
		   	}
		   	// rearrange the array
		   	$end = $teams[$count - 1];
		   	// remove the last element
		   	array_splice($teams, $count - 1, 1);
		   	// add the last element to the first index
		   	array_splice($teams, 1, 0, $end);

		   	// reset the dets, since we adjusted the array when we added the bye
		   	$dets = $originalDets;

		   	// shuffle the times so they are different every time
		   	shuffle($dets);
		}
		query("COMMIT");
		// render form
   	 	// render("confirm_schedule_form.php", ["title" => "Confirm Schedule", "data" => $data]);
   	 	print_r($data);
	}
?>