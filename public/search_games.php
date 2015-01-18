<?php

    require(__DIR__ . "/../includes/config.php");
    
    if (empty($_GET["sport"]) == TRUE)
    {
        return false;   
    }

    // check if user input early date into search
    if (empty($_GET["mindate"]) == TRUE)
    {
        $mindate = date('Y-m-d');
    }
    else
    {
        if (strtotime($_GET["mindate"]) < (time() - (60*60*12)))
        {
            $mindate = date('Y-m-d');
        }
        else
        {
            $mindate = date("Y-m-d", strtotime($_GET["mindate"]));
        }
    }

    // check if user input late date into search
    if (empty($_GET["maxdate"]) == TRUE)
    {
        $maxdate = date("Y-m-d", (time() + 60*60*24*365));
    }
    else
    {
        $maxdate = date("Y-m-d", strtotime($_GET["maxdate"]));
    }

    $games = [];
    
    // if normal user, only pull out games for their house
    if(!empty($_GET["house"]))
    {
        if ($_GET["sport"] == "all")
        {
            $games = query("SELECT * FROM games WHERE result = 0 AND (team1 = ? OR team2 = ?) AND (date >= ? AND date <= ?) ORDER BY date, time ASC", $_SESSION["house"], $_SESSION["house"], $mindate, $maxdate);
        }
        else
        {
            $games = query("SELECT * FROM games WHERE result = 0 AND sport = ? AND (team1 = ? OR team2 = ?) AND (date >= ? AND date <= ?) ORDER BY date, time ASC", $_GET["sport"], $_SESSION["house"], $_SESSION["house"], $mindate, $maxdate);
        }
    }
    // if a ref, pull out games for all houses
    else
    {
        if ($_GET["sport"] == "all")
        {
            $games = query("SELECT * FROM games WHERE result = 0 AND (date >= ? AND date <= ?) ORDER BY date, time ASC", $mindate, $maxdate);
        }
        else
        {
            $games = query("SELECT * FROM games WHERE result = 0 AND sport = ? AND (date >= ? AND date <= ?) ORDER BY date, time ASC", $_GET["sport"], $mindate, $maxdate);
        } 
    }

    // pull out all the games the user is already attending
    $attending = query("SELECT * FROM mygames WHERE userid = ?", $_SESSION["id"]);

    if (!empty($games))
    {
        for ($i = 0, $n = count($games); $i < $n; $i++)
        {
            if ($games[$i]["team1"] == $_SESSION["house"])
            {
                $games[$i]["opponent"] = $games[$i]["team2"];
            }
            else
            {
                $games[$i]["opponent"] = $games[$i]["team1"];
            }
            $games[$i]["house"] = $_SESSION["house"];
            $date = date_create($games[$i]["date"]);
            $datepretty = date_format($date, 'F d, Y');
            $games[$i]["date"] = $datepretty;
            $time = date_create($games[$i]["time"]);
            $timepretty = date_format($time, 'g:i A');
            $games[$i]["time"] = $timepretty;
            $games[$i]["attending"] = "No";
            for ($j = 0, $p = count($attending); $j < $p; $j++)
            {
                if ($games[$i]["gameid"] == $attending[$j]["gameid"])
                {
                    $games[$i]["attending"] = "Yes";
                }
            }
        }
    }
    // output places as JSON (pretty-printed for debugging convenience)
    header("Content-type: application/json");
    print(json_encode($games, JSON_PRETTY_PRINT));

?>