<?php
require 'config.php';

$pdo = pdo_connect_mysql();

$msg = "";

// check to see if the form has been submitted or check if POST data is not empty
if(!empty($_POST)){
    // check to see if the data from the form is set
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');

    // insert the contact record into the contacts table
    $stmt = $pdo->prepare("INSERT INTO contacts VALUES (NULL, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $email, $phone, $title, $created]); 

    $msg = 'New contact created successfully.';
    // header('Location: contacts.php');
    $feedback->set_feedback($msg, 'contacts'); 

}

?>

<?= template_header('Create Contact') ?>
<?= template_nav('Site Title') ?>

    <!-- feedback message -->
    <?php if ($feedback->msg and $feedback->route) : ?>
        <?= $feedback->display_feedback() ?>
    <?php endif; ?>
    
    <!-- START PAGE CONTENT -->
    <h1 class="title">Create a New Contact</h1>
    <form action="" method="post">
        <div class="field">
            <label class="label">Name</label>
            <div class="control">
                <input class="input" type="text" name="name" placeholder="Name.." required>
            </div>
        </div>

        <div class="field">
            <label class="label">Email</label>
            <div class="control">
                <input class="input" type="email" name="email" placeholder="Email.." required>
            </div>
        </div>

        <div class="field">
            <label class="label">Phone</label>
            <div class="control">
                <input class="input" type="tel" name="phone" placeholder="Phone.." required>
            </div>
        </div>

        <div class="field">
            <label class="label">Title</label>
            <div class="control">
                <input class="input" type="text" name="title" placeholder="Title..">
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">Create Contact</button>
            </div>
        </div>

    </form>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>