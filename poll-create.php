<?php
require 'config.php';

$pdo = pdo_connect_mysql();

$msg = "";

// check to see if the form has been submitted or check if POST data is not empty
if(!empty($_POST)){
    // check to see if the data from the form is set
    $title = isset($_POST['title']) ? $_POST['title'] : "";
    $desc = isset($_POST['desc']) ? $_POST['desc'] : "";

    // insert the poll record into the polls table
    $stmt = $pdo->prepare("INSERT INTO polls VALUES (NULL, ?, ?)");
    $stmt->execute([$title, $desc]);

    $poll_id = $pdo->lastInsertId();

    // get the answers and convert the multiline string into an array, so we can insert each answer into the answers table
    $answers = isset($_POST['answers']) ? explode(PHP_EOL, $_POST['answers']) : '';

    foreach($answers as $answer){
        if (empty($answer)){
            continue;
        }
        // add the answers to the answers table
        $stmt = $pdo->prepare("INSERT INTO poll_answers VALUES (NULL, ?, ?, 0)");
        $stmt->execute([$poll_id, $answer]);
        $msg = "Poll created successfully.";
        $feedback->set_feedback($msg, 'polls'); 
    }
}

?>

<?= template_header('Create Poll') ?>
<?= template_nav('Site Title') ?>

    <!-- feedback message -->
    <?php if ($feedback->msg and $feedback->route) : ?>
        <?= $feedback->display_feedback() ?>
    <?php endif; ?>

    <!-- START PAGE CONTENT -->
    <h1 class="title">Create Poll</h1>
    <form action="" method="post">
        <div class="field">
            <label class="label">Title</label>
            <div class="control">
                <input class="input" type="text" name="title" placeholder="Poll Title">
            </div>
        </div>

        <div class="field">
            <label class="label">Description</label>
            <div class="control">
                <input class="input" type="text" name="desc" placeholder="Poll Description">
            </div>
        </div>

        <div class="field">
            <label class="label">Answers (one answer per line)</label>
            <div class="control">
                <textarea name="answers" class="textarea" placeholder="Answers..."></textarea>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">Create Poll</button>
            </div>
        </div>

    </form>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>