<?php

    // configuration
    require("../includes/config.php"); 
    
    $captain = $_SESSION["captain"];

    header("Content-type: application/json");
    print(json_encode($captain, JSON_PRETTY_PRINT));
?>