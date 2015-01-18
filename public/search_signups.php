<?php

    // configuration
    require("../includes/config.php");
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] != "GET")
    {
    	return false;
    }
    else
    {
    	// define the sports to look through based on the season
    	if ($_GET["season"] == "fall")
    	{
    		$sports = ["Flag Football", "Soccer", "A Volleyball", "B Volleyball", "Ultimate Frisbee", "Tennis"];
    	}
    	elseif ($_GET["season"] == "winter")
    	{
    		$sports = ["Ice Hockey", "A Basketball", "B Basketball", "C Basketball", "Squash"];
    	}
    	elseif ($_GET["season"] == "spring")
    	{
    		$sports = ["A Crew - Men", "A Crew - Women", "B Crew - Men", "B Crew - Women", "Softball", "A Volleyball", "B Volleyball"];
    	}
    	else
    	{
    		return false;
    	}

    	// check mysports for those sports
    	$signups = [];
    	query("START TRANSACTION");
        $count = 0;
    	foreach ($sports as $sport)
    	{
    		$pref = query("SELECT pref FROM mysports WHERE userid = ? AND sport = ?", $_SESSION["id"], $sport);
            $signups[$count]["sport"] = $sport;
    		if (!empty($pref))
    		{
    			$signups[$count]["pref"] = $pref[0]["pref"];
    		}
    		else
    		{
    			$signups[$count]["pref"] = "none";
    		}
            $count++;
    	}
    	query("COMMIT");

	   	// output places as JSON (pretty-printed for debugging convenience)
	    header("Content-type: application/json");
	    print(json_encode($signups, JSON_PRETTY_PRINT));
    }
?>