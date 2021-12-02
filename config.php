<?php

// add database connection info
$DATABASE_HOST = "localhost";
$DATABASE_USER = "W01321531";
$DATABASE_PASS = "Sureshcs!";
$DATABASE_NAME = 'W01321531';

// Create connection
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

// Check connection
if (mysqli_connect_errno()) {
  // If there is an error with the connection, stop the script and display the error.
  exit("Failed to connect to MySQL: " . mysqli_connect_error());
}

function pdo_connect_mysql() {
  // pdo connection constants
  $DATABASE_HOST = "localhost";
  $DATABASE_USER = "W01321531";
  $DATABASE_PASS = "Sureshcs!";
  $DATABASE_NAME = 'W01321531';

  // PDO connection
  try {
    return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);

  } catch (PDOException $e) {
    // if there is an error with the connection, stop the script and display the error.
    exit('Error Connecting to MySQL: ' . $e->getMessage());
  }
}


function template_header($title = "Page title")
{
echo <<<EOT
 <!DOCTYPE html>
  <html>

    <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>$title</title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
     <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
     <script defer src="js/bulma.js"></script>
    </head>

  <body>
EOT;
}

function template_nav($siteTitle = "Site Title")
{
echo <<<EOT
  <!-- START NAV -->
    <nav class="navbar is-light">
      <div class="container">
        <div class="navbar-brand">
          <a class="navbar-item" href="index.php">
            <span class="icon is-large">
              <i class="fas fa-home"></i>
            </span>
            <span>$siteTitle</span>
          </a>
          <div class="navbar-burger burger" data-target="navMenu">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </div>
        <div id="navMenu" class="navbar-menu">
          <div class="navbar-start">
            <!-- navbar link go here -->
          </div>
          <div class="navbar-end">
            <div class="navbar-item">
              <div class="buttons">
                <a href="admin.php" class="button">
                  <span class="icon"><i class="fas fa-user"></i></span>
                  <span>Admin</span>
                </a>
                <a href="contact.php" class="button">
                  <span class="icon"><i class="fas fa-address-book"></i></span>
                  <span>Contact Us</span>
                </a>
                <a href="logout.php" class="button">
                  <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                  <span>Login</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <!-- END NAV -->

    <!-- START MAIN -->
    <section class="section">
        <div class="container">
EOT;
}

function template_footer()
{
echo <<<EOT
        </div>
    </section>
    <!-- END MAIN-->

    <!-- START FOOTER -->
    <footer class="footer">
        <div class="container">
            <p>Footer content goes here</p>
        </div>
    </footer>
    <!-- END FOOTER -->
    </body>
  </html>
EOT;
}

// Feedback object
class UserFeedback {
  public $msg; 
  public $route; 

  // Setter
  public function set_feedback($msg, $route) {
    $this->msg = $msg; 
    $this->route = $route;
  }

  // function to display feedback message
  public function display_feedback()
  {
    echo <<<EOT
    <div class="notification is-success">
      <h2 class="title is-3"> $this->msg Redirecting in 3 seconds.</h2>
    </div>
    EOT;
    header("Refresh:3; url=" . $this->route . ".php");
  }

}

// Instantiating global feedback object
$feedback = new UserFeedback(); 