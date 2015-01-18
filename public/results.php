<?php
    
    // configuration
    require("../includes/config.php");

	if (($sports = query("SELECT sport FROM games WHERE result = 1")) == false)
		apologize("No results posted!");
	else
	{
		for($i = 0, $n = count($sports); $i < $n; $i++) 
		{
		    $buffer[$i] = $sports[$i]["sport"];
		}
		$rows = array_unique($buffer);
		

		// alphabetize array
		sort($rows);
		// results form
		render("results_form.php", ["title" => "Results", "rows" => $rows]);  
	}
	
  

?>
