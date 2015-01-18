<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        render("recover_password_form.php", ["title" => "Recover Password"]);
    }

    // user entered username to retrieve password
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // generate a random password for the user
        // http://stackoverflow.com/questions/4356289/php-random-string-generator
        $length = 12;
        $randPass = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
        $email = $_POST["username"] . "@" . $_POST["school"] . ".harvard.edu";

        // check that the user exists by checking if query returns an empty set
        if (($user = query("SELECT * FROM users WHERE username = ?", $email)) == false)
        {
            apologize("Sorry, that e-mail does not exist in our system.");
        }
        
        $name = $user[0]["name"];
        $explode = explode(" ", $name);
        $first_name = $explode[0];

        // set the randomly generated password 
        query("UPDATE users SET password = ? WHERE username = ?", crypt($randPass), $email);

        // now mail the user with the randomly generated password
        $to = $user[0]["email"];
        $subject = 'IMguru Reset Password';
        $message = 'Dear ' . $first_name . ',' . "\r\n\r\n" . 'You have requested to reset your IMguru password. Your temporary password is: ' . $randPass . "\r\n";
        $message .= 'You may set the password to one of your choosing by logging in with the temporary password and going to the Manage Account panel. Let us know if we can assist you in any way.';
        $message .= "\r\n\r\n" . 'Go Crimson!' . "\r\n\r\n"  . 'The IMguru Team';
        $headers = 'From: register@imharvard.com' . "\r\n" .
        'Reply-To: register@imharvard.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
        if (!mail($to, $subject, $message, $headers))
            apologize("That e-mail account may not be valid.");

        render("reset_success.php", ["title" => "Success!"]);
        
    }
?>
