<?php
    
    // configuration
    require("../includes/config.php");
    
    
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // render form
        render("manage_account_form.php", ["title" => "Manage Account"]);
    }
    
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // not a referee account
        if ($_SESSION["ref"] == 0)
        {

            $rows = query("SELECT * FROM users WHERE userid = ?", $_SESSION["id"]);
            
            // empty field
            if (empty($_POST["cur_password"]) || empty($_POST["new_password1"]) || empty($_POST["new_password2"]))
            {
                apologize("Make sure you fill in all fields.");
            }
            
            // correct current password, and new passwords match
            else if ($rows[0]["password"] == crypt($_POST["cur_password"], $rows[0]["password"]) && $_POST["new_password1"] == $_POST["new_password2"])
            {
                query("UPDATE users SET password = ? WHERE userid = ?", crypt($_POST["new_password1"]), $_SESSION["id"]);

                // reload account management page and show success
                render("manage_account_form.php", ["success" => "password"]);
            }
            else
            {   
                apologize("Error resetting your password. Please try again.");
            }
        }
        // a referee account
        else
        {
            $rows = query("SELECT * FROM refs WHERE refid = ?", $_SESSION["id"]);
            
            // empty field
            if (empty($_POST["cur_password"]) || empty($_POST["new_password1"]) || empty($_POST["new_password2"]))
            {
                apologize("Make sure you fill in all fields.");
            }
            
            // correct current password, and new passwords match
            else if ($rows[0]["password"] == crypt($_POST["cur_password"], $rows[0]["password"]) && $_POST["new_password1"] == $_POST["new_password2"])
            {
                query("UPDATE refs SET password = ? WHERE refid = ?", crypt($_POST["new_password1"]), $_SESSION["id"]);

                // reload account management page and show success
                render("manage_account_form.php", ["success" => "password"]);
            }
            else
            {   
                apologize("Error resetting your password. Please try again.");
            }




        }
        
    }
?>
