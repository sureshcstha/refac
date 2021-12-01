<?php
require 'config-admin.php';

$pdo = pdo_connect_mysql();

$msg = "";

if (isset($_GET['id'])) {
    // select the record to be deleted
    $stmt = $pdo->prepare("SELECT * FROM polls WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$poll) {
        exit("Poll does not exist with that ID.");
    }

    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // delete the record
            $stmt = $pdo->prepare("DELETE FROM polls WHERE id = ?");
            $stmt->execute([$_GET['id']]);

            // we also need to delete the poll answers assoc with the poll
            $stmt = $pdo->prepare("DELETE FROM poll_answers WHERE poll_id = ?");
            $stmt->execute([$_GET['id']]);

            // output success message
            $msg = "You have deleted the poll!";
        } else {
            // redirect to the polls page
            header("Location: polls.php");
            exit;
        }
    }

} else {
    exit("No ID specified.");
}

?>

<?= template_header('Delete Poll') ?>
<?= template_nav('Site Title') ?>

    <!-- START PAGE CONTENT -->
    <h1 class="title">Delete Poll</h1>
    <?php if ($msg): ?>
        <div class="notification is-success">
            <h2 class="title is-2"><?= $msg; ?></h2>
        </div>
    <?php endif; ?>
    
    <h2 class="subtitle">Are you sure you want to delete poll number: <?= $poll['id'] ?></h2>
    <a href="poll-delete.php?id=<?= $poll['id'] ?>&confirm=yes" class="button is-danger">Yes</a>
    <a href="poll-delete.php?id=<?= $poll['id'] ?>&confirm=no" class="button is-success">No</a>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>