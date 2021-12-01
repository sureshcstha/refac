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

        // if the user clicked the vote button
        if (isset($_POST['poll_answer'])) {
            //increment the poll answer by one vote
            $stmt = $pdo->prepare('UPDATE poll_answers SET votes = votes + 1 WHERE id = ?');
            $stmt->execute([$_POST['poll_answer']]);
            header('Location: poll-result.php?id=' . $_GET['id']);
            exit;
        }
    } else {
        die('Poll with that id was is in the DB.');
    }

} else {
    die('No poll with that id exist.');
}

?>

<?= template_header('Poll Vote') ?>
<?= template_nav('Site Title') ?>

    <!-- START PAGE CONTENT -->
    <h1 class="title">Vote for: <?= $poll['title'] ?></h1>
    <p class="subtitle"><?= $poll['desc'] ?></p>
    <div class="section">
        <form action="poll-vote.php?id=<?= $_GET['id'] ?>" method="post">
        <div class="field">
            <div class="control">
                <?php for ($i = 0; $i < count($poll_answers); $i++): ?>
                    <label class="radio">
                        <input type="radio" name="poll_answer" value="<?= $poll_answers[$i]['id'] ?>" required>
                        <?= $poll_answers[$i]['title'] ?>
                    </label><br>
                <?php endfor; ?>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-primary" type="submit">Vote</button>
            </div>
        </div>

        </form>
    </div>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>