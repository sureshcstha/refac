<?php
require 'config.php';

$pdo = pdo_connect_mysql();

$msg = "";

if (isset($_GET['id'])) {
    // get contact from database
    $id = $_GET['id'];
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE id = ?');
    $stmt->execute([$id]);

    $contact = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$contact) {
        exit ('There is no contact with that ID.');
    }

    if (!empty($_POST)) {
        // update contact
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');

        $stmt = $pdo->prepare('UPDATE contacts SET id = ?, name = ?, email = ?, phone = ?, title = ?, created = ? WHERE id = ?');
        $stmt->execute([$id, $name, $email, $phone, $title, $created, $id]);
        $msg = 'Contact updated successfully.';
        $feedback->set_feedback($msg, 'contacts'); 
        // header('Location: contacts.php');
    }
} else {
    exit ('No ID specified.');
}
?>

<?= template_header('Contact Update') ?>
<?= template_nav('Site Title') ?>

    <!-- feedback message -->
    <?php if ($feedback->msg and $feedback->route) : ?>
        <?= $feedback->display_feedback() ?>
    <?php endif; ?>


    <!-- START PAGE CONTENT -->
    <h1 class="title">Contact Update</h1>
    <form action="contact-update.php?id=<?= $contact['id'] ?>" method="post">
        <div class="field">
            <label class="label">Name</label>
            <div class="control">
                <input class="input" type="text" name="name" value="<?= $contact['name']?>" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Email</label>
            <div class="control">
                <input class="input" type="text" name="email" value="<?= $contact['email']?>" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Phone</label>
            <div class="control">
                <input class="input" type="tel" name="phone" value="<?= $contact['phone']?>" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Title</label>
            <div class="control">
                <input class="input" type="text" name="title" value="<?= $contact['title']?>">
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">Update</button>
            </div>
        </div>

    </form>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>