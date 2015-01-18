<?php

    /**
     * config.php
     *
     * Computer Science 50
     * Problem Set 7
     *
     * Configures pages.
     */

    // display errors, warnings, and notices
    ini_set("display_errors", true);
    error_reporting(E_ALL);

    // requirements
    require("constants.php");
    require("functions.php");

    // enable sessions
    session_start();

    // require authentication for all pages except /login.php, /logout.php, and /register.php
    if (!in_array($_SERVER["PHP_SELF"], ["/landing.php", "/login.php", "/logout.php", "/verify.php", "/recover_password.php", "/alertupcominggame.php", "/client_side_login.php", "/referee.php", "/ref_register.php", "/ref_verify.php", "/dual.php", "/swift0.php", "/swift1.php", "/swift2.php", "/swift3.php", "/swift4.php"]))
    {
        if (empty($_SESSION["id"]))
        {
        	// go to landing page
        	if (in_array($_SERVER["PHP_SELF"], ["/index.php", "/register.php", "/ref_register.php"])) {
        		redirect("landing.php");
        	}

            redirect("login.php");
        }
    }

?>