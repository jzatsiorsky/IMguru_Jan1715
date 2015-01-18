<?php

    require(__DIR__ . "/../includes/config.php");
    
    $sport = "Football";

	print_r("<br><br>" . "SCHEDULE FOR " . strtoupper($sport));
   	$teams = ["Adams", "Cabot", "Currier", "Dudley", "Dunster", "Eliot", "Kirkland", "Leverett", "Lowell", "Mather", "Pforzheimer", "Quincy", "Winthrop"];
   	shuffle($teams);
   	$count = count($teams);
   	if ($count % 2 == 1) {
   		array_push($teams, "bye");
   		$count++;
   	}

   	$numGamesPerWeek = count($teams) / 2;
   	$startDate = "9/8/14";
   	
	$gamesPerSeason = 5;
	$dets = ["7:30 pm/Stadium/Monday", "8:30 pm/Stadium/Monday", "9:30 pm/Stadium/Monday", "10:30 pm/Stadium/Monday", "4:30 pm/Stadium/Tuesday", "3:30 pm/Stadium/Tuesday", "2:30 pm/Stadium/Wednesday"];
   			

   	print_r("<br>");
   	for ($j = 0; $j < $gamesPerSeason; $j++) {
   		print_r("<br>" . "WEEK " . ($j+1) . "<br><br>");
	   	for ($i = 0; $i < $numGamesPerWeek; $i++) {
	   		print_r(($i+1) . ". ");
	   		$details = $dets[$i];

			$explode = explode("/", $details);
   			$time = $explode[0];
   			$location = $explode[1];
   			$day = $explode[2];
   			$day = date("N", strtotime($day));
   			$startDateNum = date("N", strtotime($startDate));
   			$offset = $day - $startDateNum;
   			$team1 = $teams[$i];
   			$team2 = $teams[$count - 1 - $i];
   			$date = date("m-d", strtotime($startDate) + (60*60*24*7*$j + 60*60*24*$offset));
	   		print_r($team1 . " plays " . $team2 . " at " . $time . " on " . $date . " at " . $location . "<br>");

	   	}

	   	// rearrange the array
	   	$end = $teams[$count - 1];
	   	// remove the last element
	   	array_splice($teams, $count - 1, 1);
	   	// add the last element to the first index
	   	array_splice($teams, 1, 0, $end);

	   	// shuffle the times
	   	shuffle($dets);
	}


 

?>