<?php
    
    // configuration
    require("../includes/config.php");

    if ($_SESSION["ref"] == 1) {
	    query("COMMIT");
	    redirect("/");
	}
	else {
		apologize("You do not have access to this page.");
	}
	
?>