<?php
    require("../includes/config.php"); 
    
    // make sure the user is a captain
    if ($_SESSION["captain"] == 0)
    {
        apologize("Sorry, you do not have authorization to visit this page.");
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        render("schedule_form.php");
    }
    
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
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
        
	// change the format of the date to insert into SQL table
	$date = date("Y-m-d", strtotime($_POST["date"]));
	// http://stackoverflow.com/questions/26701256/convert-time-with-format-hhmm-am-pm-to-hhmmss
	$time = date("H:i:s", strtotime( $_POST["time"]));

        // insert the game into the schedule
        if (query("INSERT INTO games(sport, date, time, location, details, team1, team2) VALUES(?, ?, ?, ?, ?, ?, ?)", $_POST["sport"], $date,  $time, $_POST["location"], $_POST["location_details"], $_SESSION["house"], $_POST["opponent"]) === false)
        {
            apologize("Sorry, there was an error trying to schedule your game.");
        }

        redirect("/");
    }
?>
