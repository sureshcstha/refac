<?php
require 'config-admin.php';

// connect to the database using pdo
$pdo = pdo_connect_mysql();


// get all the polls from the database
$stmt = $pdo->query('SELECT p.*, GROUP_CONCAT(pa.title ORDER BY pa.id) AS answers
                        FROM polls p LEFT JOIN poll_answers pa ON pa.poll_id = p.id GROUP BY p.id');

$polls = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?= template_header('Polls') ?>
<?= template_nav('Site Title') ?>

<div class = "columns">
    <?php include "sidebar.php"; ?>

    <!-- START RIGHT CONTENT COLUMN-->
    <div class = "column">
        <!-- START PAGE CONTENT -->
        <h1 class="title">Polls</h1>
        <p class="subtitle">Welcome, here is the list of polls.</p>
        <a href="poll-create.php" class="button is-primary is-small">
            <span class="icon">
                <i class="fa fa-plus-square"></i>
            </span>
            <span>Create a new poll</span>
        </a>
        <p>&nbsp;</p>
        <div class="container">
            <table class="table is-bordered is-hoverable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Answers</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($polls as $poll) : ?>
                        <tr>
                            <td><?= $poll['id'] ?></td>
                            <td><?= $poll['title'] ?></td>
                            <td><?= $poll['answers'] ?></td>
                            <td>
                                <a href="poll-vote.php?id=<?= $poll['id'] ?>" class="button is-small is-link">
                                    <span class="icon">
                                        <i class="fas fa-poll"></i>
                                    </span>
                                    <span>Vote</span>
                                </a>
                                <a href="poll-delete.php?id=<?= $poll['id'] ?>" class="button is-small is-danger">
                                    <span class="icon">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                    <span>Delete</span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>

                </tbody>

            </table>
        </div>
        <!-- END PAGE CONTENT -->
    </div>
</div>

<?= template_footer() ?>