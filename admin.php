<?php
require 'config-admin.php';

// We need to use sessions, so we should always start sessions using the code below.
session_start();

// if not logged in, redirect to login page
if (!isset($_SESSION['logged in'])) {
    header('Location: login.php');
    exit;
}

// query the database for the profile details
// we don't have the password or email info stored in sessions so instead
//we can get the results from the database

$stmt = $con->prepare('SELECT password, email FROM accounts WHERE id = ?');
// In this case we can use the account ID session variable to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();
?>

<?= template_header('Profile') ?>
<?= template_nav('Site Title') ?>

<div class = "columns">
    <?php include "sidebar.php"; ?>

    <!-- START RIGHT CONTENT COLUMN-->
    <div class = "column">
        <!-- START PAGE CONTENT -->
        <h1 class="title">Dashboard</h1>
        <p class="subtitle">Welcome!</p>
        <!-- END PAGE CONTENT -->
    </div >
<!-- END RIGHT CONTENT COLUMN-->
</div >

<?= template_footer() ?>