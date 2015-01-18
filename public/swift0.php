<?php

    require(__DIR__ . "/../includes/config.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
	    // get all of James' games
	    $games = query("SELECT * FROM games INNER JOIN mygames ON games.gameid=mygames.gameid WHERE mygames.userid = 26 AND games.result = 0 AND games.date >= CURDATE() ORDER BY date, time ASC");
	    $array = array();
	    // create array of gameid's
	    /*
	    foreach ($games as $game) {
	    	array_push($array, $game["gameid"]);
	    }
	    */

	   	$venues = query("SELECT * FROM venues");
	   	$rosters = query("SELECT * FROM mygames INNER JOIN users ON mygames.userid = users.userid WHERE users.house = 'Adams'");
	   	$announcements = query("SELECT * FROM announcements INNER JOIN myannouncements ON announcements.announcementid = myannouncements.announcementid WHERE myannouncements.userid = 26 ORDER BY time DESC");
	 	$otherGames = query("SELECT * FROM games WHERE games.gameid NOT IN (SELECT gameid FROM mygames WHERE mygames.userid = ?) AND (games.team1 = ? OR games.team2 = ?) AND result = 0", 26, "Adams", "Adams");
	   	// Standings
	   		// Set your CSV feed
		$feed = 'https://spreadsheets.google.com/tq?tqx=out:csv&key=0AgMRlqC2ExQudHAyX0sycXdac2dxb0pWSTlndS1RRGc';
		 
		// Arrays we'll use later
		$keys = array();
		$newArray = array();
		 
		// Function to convert CSV into associative array
		function csvToArray($file, $delimiter) { 
		  if (($handle = fopen($file, 'r')) !== FALSE) { 
			$i = 0; 
			while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) { 
			  for ($j = 0; $j < count($lineArray); $j++) { 
			    $arr[$i][$j] = $lineArray[$j]; 
			  } 
			  $i++; 
			} 
			fclose($handle); 
		  } 
		  return $arr; 
		} 
		 
		// Do it
		$data = csvToArray($feed, ',');
		 
		// Set number of elements (minus 1 because we shift off the first row)
		$count = count($data) - 1;
		 
		//Use first row for names  
		$labels = array_shift($data);  
		 
		foreach ($labels as $label) {
		  $keys[] = $label;
		}
		 
		// Add Ids, just in case we want them later
		$keys[] = 'id';
		 
		for ($i = 0; $i < $count; $i++) {
		  $data[$i][] = $i;
		}
		 
		// Bring it all together
		for ($j = 0; $j < $count; $j++) {
		  $d = array_combine($keys, $data[$j]);
		  $newArray[$j] = $d;
		}

		// Obtain a list of columns
		foreach ($newArray as $key => $row) {
			$rank[$key]  = $row['Rank'];
		}


		// Add $data as the last parameter, to sort by the common key
		array_multisort($rank, SORT_ASC, $newArray);

	    $data = array("games" => $games, "venues" => $venues, "rosters" => $rosters, "announcements" => $announcements, "standings" => $newArray, "otherGames" => $otherGames);

	    // output places as JSON (pretty-printed for debugging convenience)
	    header("Content-type: application/json");
	    print(json_encode($data, JSON_PRETTY_PRINT));
	}
	else {
		// coming from announcement page
		if (isset($_POST["announcementid"])) {
			$userid = $_POST["userid"];
			$announcementid = $_POST["announcementid"];

			query("DELETE FROM myannouncements WHERE userid = ? AND announcementid = ?", $userid, $announcementid);
		}
		// coming from my games page
		else {
			$userid = $_POST["userid"];
			$gameid = $_POST["gameid"];

			query("DELETE FROM mygames WHERE userid = ? AND gameid = ?", $userid, $gameid);

		}

	}

?>