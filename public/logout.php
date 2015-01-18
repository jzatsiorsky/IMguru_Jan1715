<?php

    // configuration
    require("../includes/config.php"); 

    // store whether or not user is a ref
    $ref = $_SESSION["ref"];

    // log out current user, if any
    logout();

    // redirect user based on referee status
    if ($ref == 0)
    	redirect("/");
    else
    	redirect("/referee.php");

?>
