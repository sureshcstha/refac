<?php
require 'config.php';

$response = '';

// check if data was submitted
if (isset($_POST['username'], $_POST['password'], $_POST['email'] )) {
    // check if the account with username already exist
    if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Username already exists
            echo 'Username exists, please choose another!';
        } else {
            // create a new user account
            if ($stmt->prepare('INSERT INTO accounts (username, password, email, activation_code) VALUES (? , ?, ?, ?)')) {
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $uniqid = uniqid();

                $stmt->bind_param('ssss', $_POST['username'], $password, $_POST['email'], $uniqid);
                $stmt->execute();

                // send confirmation email
                $from = 'sureshcstha@gmail.com';
                $subject = 'Account activation required';
                $header = $headers = 'From: ' . $from . "\r\n" .
                    'Reply-To: ' . $from . "\r\n" .
                    'X-Mailer: PHP/' . phpversion() . "\r\n" . 
                    'MIME Version: 1.0' . "\r\n" .
                    'Content-Type: text/html; charset="UTF-8' . "\r\n";
                $activate_link = 'https://icarus.cs.weber.edu/~ss21531/web3400/project2/activate.php?email=' . $_POST['email'] . '&code=' . $uniqid;
                $message = '<p> Please check the following link to activate your account: <a href="' . $activate_link . '">' . $activate_link . '</a></p>';

                // mail();
                echo "<a href='$activate_link'>$activate_link</a>";

            } else {
                echo 'Could not prepare statement!';
            }
        }
    }
    $stmt->close();
    $con->close();
}
?>

<?= template_header('Register') ?>
<?= template_nav('Site Title') ?>

    <!-- START PAGE CONTENT -->
    <!-- message sent confirmation message goes here -->
    <?php if ($response) : ?>
        <div class="notification is-success">
            <h2 class="title is-2"><?php echo $response; ?></h2>
        </div>
    <?php endif; ?>

    <!-- form -->
    <h1 class="title">Register</h1>
    <form action="" method="post">
        <div class="field">
            <label class="label">Username</label>
            <div class="control has-icons-left">
                <input name="username" class="input" type="text" placeholder="e.g. test" required>
                <span class="icon is-left">
                    <i class="fas fa-user"></i>
                </span>
            </div>
        </div>
        <div class="field">
            <label class="label">Password</label>
            <div class="control has-icons-left">
                <input name="password" class="input" type="password" placeholder="e.g. password" required>
                <span class="icon is-left">
                    <i class="fas fa-lock"></i>
                </span>
            </div>
        </div>
        <div class="field">
            <label class="label">Email</label>
            <div class="control has-icons-left">
                <input name="email" class="input" type="email" placeholder="e.g. alexsmith@gmail.com" required>
                <span class="icon is-left">
                    <i class="fas fa-envelope"></i>
                </span>
            </div>
        </div>
        <div class="field">
            <div class="control ">
                <button class="button is-info">
                    Register 
                </button>
            </div>
        </div>
    </form>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>