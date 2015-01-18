<?php

    // configuration
    require("../includes/config.php"); 
    
    // set the time zone to the East Coast
        query("SET time_zone = 'America/New_York'");
        
        query("START TRANSACTION");

    // referee account
    if ($_SESSION["ref"] == 1)
    {
        // numerically indexed array of my games, ordered by date (only show games in the future)
        $rows = query("SELECT * FROM games INNER JOIN refgames ON games.gameid=refgames.gameid WHERE refgames.refid = ? AND games.result = 0 AND games.date >= CURDATE() ORDER BY date, time ASC", $_SESSION["id"]);

        // numerically indexed array of recent results for ticker
        $results = query("SELECT * FROM games WHERE result = TRUE AND forfeit = 0 ORDER BY date DESC LIMIT 8");

        render("portfolio.php", ["title" => "Ref Home", "rows" => $rows, "results" => $results]);
    }

    // not a referee account
    else
    {
        // numerically indexed array of my games, ordered by date (only show games in the future)
        $rows = query("SELECT * FROM games INNER JOIN mygames ON games.gameid=mygames.gameid WHERE mygames.userid = ? AND games.result = 0 AND games.date >= CURDATE() ORDER BY date, time ASC", $_SESSION["id"]);

        // numerically indexed array of recent results for ticker
        $results = query("SELECT * FROM games WHERE result = TRUE AND forfeit = 0 ORDER BY date DESC LIMIT 8");

        // get the announcements relevant to the user
        $announcements = query("SELECT * FROM myannouncements INNER JOIN announcements ON myannouncements.announcementid = announcements.announcementid WHERE myannouncements.userid = ?", $_SESSION["id"]);

        query("COMMIT");

        // render home page
        render("portfolio.php", ["title" => "Home", "rows" => $rows, "results" => $results, "announcements" => $announcements]);
    }
?>
