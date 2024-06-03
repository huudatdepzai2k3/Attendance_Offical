<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset password</title>
  <link rel="icon" href="icons/humg-logo.png" >
</head>
<body>
  <?php include'header.php'; ?> 
  <center class="section-defaulf slideInLeft animated">
      <h1>Reset your password</h1>
      <p style="color: #fff;">An email will be send to you with instruction on how to reset your password.</p>
      <?php  
        if (isset($_GET['error'])) {
          if ($_GET['error'] == "invalidEmail") {
              echo '<div class="alert alert-danger error_show_width">
                      This E-mail is invalid!!
                    </div>';
          }
          elseif ($_GET['error'] == "sqlerror") {
              echo '<div class="alert alert-danger error_show_width">
                      There a database error!!
                    </div>';
          }
          elseif ($_GET['error'] == "nouser") {
              echo '<div class="alert alert-danger error_show_width">
                      This E-mail does not exist!!
                    </div>';
          }
          elseif ($_GET['error'] == "send_mail") {
            echo '<div class="alert alert-danger error_show_width">
                    Send email failed, please try again later!!
                  </div>';
          }     
        }
      ?>
      <form action="includes/reset-request.inc.php"  method="post" class="form_default">
          <input type="email" name="email" class="form_config_input" placeholder="Enter your e-mail address..." required></br>
          <button type="submit" name="reset-request-submit" class="button_config">Receive link by e-mail</button>
      </form>
  
      <?php
        if(isset($_GET["reset"])) {
          if($_GET["reset"] == "success") {
              echo '<p class="signupsuccess" style="color: blue;">An email has sent, please check your email!</p>';
          }
        }
      ?>
  </center>
</body>
</html>
<main>
</main>

