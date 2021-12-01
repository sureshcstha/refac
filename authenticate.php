<?php

require 'config.php';

session_start();

// var_dump($_POST);

if (!isset($_POST['username'], $_POST['password'])) {
    exit('Please fill out both username and password fields.');
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    // Bind parameters, in our case the username is a string so we use "s"
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();

    // Store the result so we can check if the account exixts in the database.
    $stmt->store_result();

    // authenticate the user by checking for the username, if the username exists then we will check the password
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        // Account exists, now we verify the password.
        // Note: remember to use password_has in your registration file to store the hashed password.
        if (password_verify($_POST['password'], $password)) {
            // Verification success! User has logged-in!

            // Create session, so we know the user is logged in, they basically act like cookies but remember the data on the
            session_regenerate_id();
            $_SESSION['logged in'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            // echo "You logged in successfully.";
            header('Location: profile.php');
        } else {
            echo "Incorrect password";
        }

    } else {
        echo "Incorrect username";
    }
    $stmt->close();
}
?>