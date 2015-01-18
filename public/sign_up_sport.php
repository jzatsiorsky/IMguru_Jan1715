<?php

  // configuration
  require("../includes/config.php");

  // some variables
  $sport = $_POST["sport"];	   // sport the user wants to sign up for
  $userid = $_SESSION["id"];   // user's id
  $house = $_SESSION["house"]; // user's house

  if ($sport == "all")
  {
    $games = query("SELECT gameid FROM games WHERE team1 = ? OR team2 = ?", $house, $house);
    // loop through each game
    foreach ($games as $game)
    {
      $gameid = $game["gameid"];
      // for each individual game, insert the user into the roster for that game
      query("INSERT INTO mygames (gameid, userid) VALUES (?, ?)", $gameid, $userid);
    }
  }

  else
  {
    // get all of the games of the indicated sport in which the user's house is playing
    $games = query("SELECT gameid FROM games WHERE sport = ? AND (team1 = ? OR team2 = ?)", $sport, $house, $house);

    // loop through each game
    foreach ($games as $game)
    {
    	$gameid = $game["gameid"];
    	// for each individual game, insert the user into the roster for that game
    	query("INSERT INTO mygames (gameid, userid) VALUES (?, ?)", $gameid, $userid);
    }
  }

?>