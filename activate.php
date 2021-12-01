<?php
require 'config.php';

// check if the email and code exiists

if (isset($_GET['email'], $_GET['code'])) {
    if ($stmt = $con->prepare('SELECT * FROM accounts WHERE email = ? AND activation_code = ?')) {
        $stmt->bind_param('ss', $_GET['email'], $_GET['code']);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // account is in the database
            if ($stmt->prepare('UPDATE accounts SET activation_code = ? WHERE email = ? AND activation_code = ?')) {
                $newcode = 'activated';
                $stmt->bind_param('sss', $newcode, $_GET['email'], $_GET['code']);
                $stmt->execute();
                echo "Your account has been activated.";
            }
        } 
    }

} else {
    echo 'The account is already activated or doesn\'t exist!';
}