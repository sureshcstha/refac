<?php
require 'config.php';

$pdo = pdo_connect_mysql();

$msg = "";

if (isset($_GET['id'])) {
    // select the record to be deleted
    $stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$contact) {
        exit("Contact does not exist with that ID.");
    }

    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // delete the record
            $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
            $stmt->execute([$_GET['id']]);

            // output success message
            $msg = "You have deleted the contact!";
            $feedback->set_feedback($msg, 'contacts'); 
        } else {
            // redirect to the contacts page
            header("Location: contacts.php");
            exit;
        }
    }

} else {
    exit("No ID specified.");
}

?>

<?= template_header('Delete Contact') ?>
<?= template_nav('Site Title') ?>

    <!-- feedback message -->
    <?php if ($feedback->msg and $feedback->route) : ?>
        <?= $feedback->display_feedback() ?>
    <?php endif; ?>

    <!-- START PAGE CONTENT -->
    <h1 class="title">Delete Contact</h1>
    <h2 class="subtitle">Are you sure you want to delete contact number: <?= $contact['id'] ?></h2>
    <a href="contact-delete.php?id=<?= $contact['id'] ?>&confirm=yes" class="button is-danger">Yes</a>
    <a href="contact-delete.php?id=<?= $contact['id'] ?>&confirm=no" class="button is-success">No</a>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>