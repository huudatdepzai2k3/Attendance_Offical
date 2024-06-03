<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change password</title>
  <link rel="icon" href="icons/humg-logo.png" >
</head>
<body>
  <?php include'header.php'; ?> 
  <center class="section-defaulf zoom_ani animated">
      <h1>Change password login</h1>
      <?php  
        if (isset($_GET['error'])) {
          if ($_GET['error'] == "password_false") {
              echo '<div class="alert alert-danger error_show_width">
                      Password login not correct!!
                    </div>'; 
          }
          elseif ($_GET['error'] == "pwdnotsame") {
              echo '<div class="alert alert-danger error_show_width">
              New password and new repeat password not same!!
                    </div>';
          } 
          elseif ($_GET['error'] == "password_o_n_same") {
            echo '<div class="alert alert-danger error_show_width">
            The new password and the existing password are the same!!
                  </div>';
          } elseif ($_GET['error'] == "sql") {
            echo '<div class="alert alert-danger error_show_width">
            The Database error!!!!
                  </div>';
          }
        }
      ?>
      <form action="includes/change_pwd_login.inc.php"  method="post" class="form_default">
          <input type="password" name="pwd_new" class="form_config_input" placeholder="Enter your new password ..." required>
          <input type="password" name="pwd_new_repeat" class="form_config_input" placeholder="Repeat your new password ..." required>
          <input type="password" name="pwd_recently" class="form_config_input" placeholder="Enter your password login ..." required>
          <button type="submit" name="button-change-submit" class="button_config">Change</button>
      </form>
      <?php  
        if(isset($_GET['new_change']) == "passwordupdated") {
          echo '<p class="success_notifi"> Your password has been changed!!</p>';
        }
      ?>
  </center>
</body>
</html>
