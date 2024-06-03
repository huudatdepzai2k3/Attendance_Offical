<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change email</title>
  <link rel="icon" href="icons/humg-logo.png" >
</head>
<body>
  <?php include'header.php'; ?> 
  <center class="section-defaulf zoom_ani animated">
      <h1>Change email login</h1>
      <?php  
        if (isset($_GET['error'])) {
          if ($_GET['error'] == "sql") {
              echo '<div class="alert alert-danger error_show_width">
                      The Database error!!
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
          elseif ($_GET['error'] == "emails_same") {
             echo '<div class="alert alert-danger error_show_width">
                    New email and current email are the same!!
                </div>';
          } else if ($_GET['error'] == "pwd_incorrect") {
              echo '<div class="alert alert-danger error_show_width">
                 Current password incorrect!!
              </div>';
          } else if ($_GET['error'] == "out_time_check") {
            echo '<div class="alert alert-danger error_show_width">
               The OTP expired, please change the email again to continue!!
            </div>';
          }
        }
      ?>
      <form action="includes/change_email_login.inc.php"  method="post" class="form_default">
          <input type="email" name="email_new" class="form_config_input" placeholder="Enter your new email ..." required>
          <input type="password" name="pwd_recently" class="form_config_input" placeholder="Enter your password login ..." required>
          <button type="submit" name="button-change-submit" class="button_config">Change</button>
      </form>
  </center>
</body>
</html>
