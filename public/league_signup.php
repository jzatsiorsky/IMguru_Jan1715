<?php

    // configuration
    require("../includes/config.php");
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // make sure the user is not a ref
    	if ($_SESSION["ref"] == 1)
    	{
    		apologize("Only peasant players can use this page.");
    	}

        // list the sports by season so they will be printed in those groups
    	$fall = ["Flag Football", "Soccer", "A Volleyball", "B Volleyball", "Ultimate Frisbee", "Tennis"];
    	$winter = ["Ice Hockey", "A Basketball", "B Basketball", "C Basketball", "Squash"];
    	$spring = ["A Crew - Men", "A Crew - Women", "B Crew - Men", "B Crew - Women", "Softball", "A Volleyball", "B Volleyball"];
        $seasons["fall"] = $fall;
        $seasons["winter"] = $winter;
        $seasons["spring"] = $spring;
        // get the user's current signup preferences
        $preferences = query("SELECT sport, pref FROM mysports WHERE userid = ? ORDER BY pref ASC", $_SESSION["id"]);
        $listpref = [];
        $rosterpref = [];

        foreach ($preferences as $preference)
        {
            if ($preference["pref"] == "all")
            {
                array_push($rosterpref, $preference["sport"]);
            }
            elseif ($preference["pref"] == "email")
            {
                array_push($listpref, $preference["sport"]);
            }
        }
        // load the form
    	render("league_signup_form.php", ["seasons" => $seasons, "lists" => $listpref, "rosters" => $rosterpref]);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $sports = array_keys($_POST);
        
        query("START TRANSACTION");

        for ($i = 0, $n = count($sports); $i < $n; $i++)
        {
            $sport = $sports[$i];
            // only 
            if (!empty($_POST[$sport]))
            {
                $pref = $_POST[$sport];
                $sport = str_replace("_", " ", $sport);
                // see if the user already has preferences for that sport
                $oldpref = query("SELECT * FROM mysports WHERE userid = ? AND sport = ?", $_SESSION["id"], $sport);
                // if they do not have preferences for the sport:
                if (empty($oldpref))
                {
                    // if the player wants to be added to a league, put their info in the myleagues table
                    if ($pref != "none")
                    {
                        // add the new preference into the mysports table
                        query("INSERT INTO mysports(userid, sport, pref) VALUES (?, ?, ?)", $_SESSION["id"], $sport, $pref);

                        // if they signed up for all rosters, add them to the roster for all of those upcoming games
                        if ($pref == "all")
                        {
                            $gameids = query("SELECT gameid FROM games WHERE (team1 = ? OR team2 = ?) AND sport = ? and date >= CURDATE()", $_SESSION["house"], $_SESSION["house"], $sport);
                            foreach ($gameids as $gameid)
                            {
                                query("INSERT INTO mygames (userid, gameid) VALUES (?, ?)", $_SESSION["id"], $gameid["gameid"]);
                            }
                        }
                    }
                    // otherwise delete them being signed up for any of the games for that sport
                    else
                    {
                        $gameids = query("SELECT gameid FROM games WHERE (team1 = ? OR team2 = ?) AND sport = ? and date >= CURDATE()", $_SESSION["house"], $_SESSION["house"], $sport);
                        foreach ($gameids as $gameid)
                        {
                            query("DELETE FROM mygames WHERE userid = ? and gameid = ?", $_SESSION["id"], $gameid["gameid"]);
                        }
                    }
                }
                // but if they do already have preferences for the sport:
                else
                {
                    if ($pref != "none")
                    {
                        // update the new preference into the mysports table
                        query("UPDATE mysports SET pref = ? WHERE userid = ? AND sport = ?", $pref, $_SESSION["id"], $sport);

                        // if they changed to sign up for all rosters, add them to the roster for all of those upcoming games
                        if ($pref == "all")
                        {
                            $gameids = query("SELECT gameid FROM games WHERE (team1 = ? OR team2 = ?) AND sport = ? and date >= CURDATE()", $_SESSION["house"], $_SESSION["house"], $sport);
                            foreach ($gameids as $gameid)
                            {
                                query("INSERT INTO mygames (userid, gameid) VALUES (?, ?)", $_SESSION["id"], $gameid["gameid"]);
                            }
                        }
                    }
                    // otherwise delete that sport from their mysports table and the user from any rosters for that sport
                    else
                    {
                        query("DELETE FROM mysports WHERE userid = ? AND sport = ?", $_SESSION["id"], $sport);
                        $gameids = query("SELECT gameid FROM games WHERE (team1 = ? OR team2 = ?) AND sport = ? and date >= CURDATE()", $_SESSION["house"], $_SESSION["house"], $sport);
                        foreach ($gameids as $gameid)
                        {
                            query("DELETE FROM mygames WHERE userid = ? and gameid = ?", $_SESSION["id"], $gameid["gameid"]);
                        }
                    }
                }
            }
        }
        query("COMMIT");
        redirect("/");
    }
?>