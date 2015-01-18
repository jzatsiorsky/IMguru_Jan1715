<?php

    require(__DIR__ . "/../includes/config.php");
    
    // get coordinates
    $data = query("SELECT * FROM venues WHERE name = ?", $_GET["place"]);
    
    // output places as JSON (pretty-printed for debugging convenience)
    header("Content-type: application/json");
    print(json_encode($data, JSON_PRETTY_PRINT));

?>