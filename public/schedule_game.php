<?php
    require("../includes/config.php"); 
    
    // if not a ref account, check captain status
    if ($_SESSION["ref"] == 0)
    {

    // make sure the user is a captain
        if ($_SESSION["captain"] == 0)
        {
            apologize("Sorry, you do not have authorization to visit this page.");
        }
    }

        
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $rows = query("SELECT name FROM venues");
        for($i = 0, $n = count($rows); $i < $n; $i++) 
		{
		    $buffer[$i] = $rows[$i]["name"]; 
		}
		$venues = array_unique($buffer);
        render("schedule_form.php", ["venues" => $venues, "title" => "Schedule game"]);
    }
    
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // not a ref account
        if ($_SESSION["ref"] == 0) {
            // make sure the user filled in all fields
            if (empty($_POST["sport"]) || empty($_POST["opponent"]) || empty($_POST["date"]) || empty($_POST["time"]) || empty($_POST["location"]))
            {
                apologize("Please fill in all of the fields in the form.");
            }
            
            // make sure the user didn't put in their own house as the opponent
            if ($_POST["opponent"] == $_SESSION["house"])
            {
                apologize("You can't play against your own house in an IM game!");
            }
        }
        // ref account
        else {
            // make sure the user filled in all fields
            if (empty($_POST["sport"]) || empty($_POST["team1"]) || empty($_POST["team2"]) || empty($_POST["date"]) || empty($_POST["time"]) || empty($_POST["location"]))
            {
                apologize("Please fill in all of the fields in the form.");
            }
            // make sure the user didn't put in their own house as the opponent
            if ($_POST["team1"] == $_POST["team2"])
            {
                apologize("A house cannot play against itself! Please fill out the form again.");
            }
        }
	// change the format of the date to insert into SQL table
	$date = date("Y-m-d", strtotime($_POST["date"]));
	// http://stackoverflow.com/questions/26701256/convert-time-with-format-hhmm-am-pm-to-hhmmss
	$time = date("H:i:s", strtotime( $_POST["time"]));

    if ($_SESSION["ref"] == 0) {
        // insert the game into the schedule
        if (query("INSERT INTO games(sport, date, time, location, details, team1, team2) VALUES(?, ?, ?, ?, ?, ?, ?)", $_POST["sport"], $date,  $time, $_POST["location"], $_POST["location_details"], $_SESSION["house"], $_POST["opponent"]) === false)
        {
            apologize("Sorry, there was an error trying to schedule your game.");
        }
        // get the gameid for the game just scheduled
        $gameid = query("SELECT LAST_INSERT_ID() FROM games LIMIT 1");
        // add all the players signed up to be added to rosters for that sport in mysports to the roster for the game
        $players = query("SELECT * FROM mysports INNER JOIN users ON mysports.userid = users.userid WHERE sport = ? AND pref = 'all' AND (house = ? OR house = ?)", $_POST["sport"], $_SESSION["house"], $_POST["opponent"]);
        foreach ($players as $player)
        {
            query("INSERT INTO mygames (userid, gameid) VALUES(?, ?)", $player["userid"], $gameid[0]["LAST_INSERT_ID()"]);
        }
    }
    else {
       if (query("INSERT INTO games(sport, date, time, location, details, team1, team2) VALUES(?, ?, ?, ?, ?, ?, ?)", $_POST["sport"], $date,  $time, $_POST["location"], $_POST["location_details"], $_POST["team1"], $_POST["team2"]) === false)
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

        redirect("/");
    }
?>