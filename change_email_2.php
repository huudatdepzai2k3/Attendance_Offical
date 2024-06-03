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
  <center class="section-defaulf Opacity">
      <h1>Enter OTP has receved in new email</h1>
      <?php  
        if (isset($_GET['error'])) {
          if ($_GET['error'] == "sql") {
              echo '<div class="alert alert-danger error_show_width">
                The Database error!!
              </div>';
          } else if ($_GET['error'] == "otp_incorrect") {
            echo '<div class="alert alert-danger error_show_width">
                The OTP code just entered is incorrect, please enter it again!!
              </div>';
          }
        }
      ?>
      <form action="includes/change_email_login_2.inc.php"  method="post" class="form_default">
          <input type="Text" name="OTP_in" class="form_config_input" placeholder="Enter OTP ..." required>
          <button type="submit" name="conirm-change-submit" class="button_config">Confirm</button>
      </form>
      <?php 
        if(isset($_GET['success']) == "email_change") {
          echo '<p class="success_notifi"> Your email has been changed!!</p>';
        }
      ?>
  </center>
</body>
</html>
