<?php
require 'config.php';

$pdo = pdo_connect_mysql();

$msg = "";

if (isset($_GET['id'])) {
    // get the poll answers for the poll that matches the GET id
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    // get the record
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);

    // check to see if the poll exists
    if ($poll) {
        // get the poll answers for the poll
        $stmt = $pdo->prepare('SELECT * FROM poll_answers WHERE poll_id = ?');
        $stmt->execute([$_GET['id']]);
        // get all the answers
        $poll_answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // total number of votes
        $total_votes = 0;

        foreach ($poll_answers as $poll_answer) {
            $total_votes += $poll_answer['votes'];
        }

    } else {
        die('Poll with that id was is in the DB.');
    }

} else {
    die('No poll with that id exist.');
}

?>

<?= template_header('Poll Results') ?>
<?= template_nav('Site Title') ?>

    <!-- START PAGE CONTENT -->
    <h1 class="title">Poll Results</h1>
    <p class="subtitle"><?= $poll['title']?>(Total Votes: <?=$total_votes?>)</p>
    <div class="container">
        <?php foreach ($poll_answers as $poll_answer): ?>
            <p><?=$poll_answer['title']?>(<?=$poll_answer['votes']?>)</p>
            <progress class="progress is-primary is-large"
                value="<?=$poll_answer['votes']?>" max="<?=$total_votes?>">
            </progress>
        <?php endforeach; ?>
    </div>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>