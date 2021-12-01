<?php
require 'config.php';

//additional php code for this page goes here

//php to send email goes here
$response = '';

if (isset($_POST['email'], $_POST['name'] )) {
    echo var_dump($_POST);

    // update response
    $response = "Message Sent!"; 
}

?>

<?= template_header('Contact US') ?>
<?= template_nav('My Site') ?>

    <!-- START PAGE CONTENT -->
    <h1 class="title">Contact US</h1>
     <!-- message sent confirmation message goes here -->
        <?php if ($response) : ?>
            <div class="notification is-success">
                <h2 class="title is-2"><?php echo $response; ?></h2>
            </div>
        <?php endif; ?>
        
        <!-- form -->
        <form action="" method="post">
            <div class="field">
                <label class="label">Name</label>
                <div class="control has-icons-left">
                    <input class="input" type="text" name="name" placeholder="e.g Alex Smith" required>
                    <span class="icon is-left">
                        <i class="fas fa-user"></i>
                    </span>
                </div>
            </div>

            <div class="field">
                <label class="label">Email</label>
                <div class="control has-icons-left">
                    <input class="input" type="email" name="email" placeholder="e.g. alexsmith@gmail.com" required>
                    <span class="icon is-left">
                        <i class="fas fa-envelope"></i>
                    </span>
                </div>
            </div>

            <div class="field">
                <label class="label">Subject</label>
                <div class="control">
                    <input class="input" name="subject" type="text" placeholder="Message subject..." required>
                </div>
            </div>

            <div class="field">
                <label class="label">Message</label>
                <div class="control">
                    <textarea class="textarea" name="message" placeholder="Message" required></textarea>
                </div>
            </div>

            <div class="field">
                <div class="control ">
                    <button class="button is-normal is-info submit-button">
                        <i class="fas fa-paper-plane"></i>
                        &nbsp;&nbsp; Send Message 
                    </button>
                </div>
            </div>

        </form>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>