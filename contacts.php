<?php
require 'config-admin.php';

// connect to the database using pdo
$pdo = pdo_connect_mysql();


// get all the polls from the database
$stmt = $pdo->query('SELECT * FROM contacts');

$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?= template_header('Contacts') ?>
<?= template_nav('Site Title') ?>

<div class = "columns">
    <?php include "sidebar.php"; ?>

    <!-- START RIGHT CONTENT COLUMN-->
    <div class = "column">
        <!-- START PAGE CONTENT -->
        <h1 class="title">Contacts</h1>
        <p class="subtitle">Welcome, here is the list of your contacts.</p>
        <a href="contact-create.php" class="button is-primary is-small">
            <span class="icon">
                <i class="fa fa-plus-square"></i>
            </span>
            <span>Create a new contact</span>
        </a>
        <p>&nbsp;</p>
        <div class="container">
            <table class="table is-bordered is-hoverable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Title</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $contact) : ?>
                        <tr>
                            <td><?= $contact['id'] ?></td>
                            <td><?= $contact['name'] ?></td>
                            <td><?= $contact['email'] ?></td>
                            <td><?= $contact['phone'] ?></td>
                            <td><?= $contact['title'] ?></td>
                            <td><?= $contact['created'] ?></td>
                            <td>
                                <a href="contact-update.php?id=<?= $contact['id'] ?>" class="button is-small is-link">
                                    <span class="icon">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                    <span>Update</span>
                                </a>
                                <a href="contact-delete.php?id=<?= $contact['id'] ?>" class="button is-small is-danger">
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
    </div>
</div>

    <!-- END PAGE CONTENT -->

<?= template_footer() ?>