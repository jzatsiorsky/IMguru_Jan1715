<?php

	require("../includes/config.php");

	if ($_SERVER["REQUEST_METHOD"] == "GET")
	{
		$houses = ["Adams", "Cabot", "Currier", "Dudley", "Dunster", "Eliot", "Kirkland", "Leverett", "Lowell", "Mather", "Pforzheimer", "Quincy", "Winthrop"];
		$sport1 = "A Basketball";
		$sport2 = "Squash";

		foreach($houses as $house)
		{
			query("INSERT INTO standings (house, sport) VALUES (?, ?)", $house, $sport1);
			query("INSERT INTO standings (house, sport) VALUES (?, ?)", $house, $sport2);
		}

		$success = "works";
		dump($success);

	}
	else
	{
		return false;
	}

?>