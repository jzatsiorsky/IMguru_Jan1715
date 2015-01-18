<?php
    
    // configuration
    require("../includes/config.php");

    if ($_SESSION["ref"] == 1) {
	    query("ROLLBACK");
	    redirect("/create_schedule.php");
	}
	else {
		apologize("You do not have access to this page.");
	}
	
?>