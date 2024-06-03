
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create new password</title>
    <link rel="icon" href="icons/humg-logo.png" >
  </head>
  <body>
    <?php include'header.php'; ?> 
    <center class="section-defaulf slideInDown animated">
      <h1>Below is the new password creation form, please enter your new password here</h1>
        <?php
          include('connectDB.php');
          $sql = "SELECT * FROM check_url";
          $result = mysqli_query($conn , $sql);
          if(mysqli_num_rows($result) == 1) {
            while($row = mysqli_fetch_array($result)){
              $selector = $row['selector_check'];
              $validator = $row['validator_check'];
              $timecreate = $row['time_create'];
            }
            $time_now = time();
          }
          
          // change string to integer
          $time_check_now = intval($time_now);
          $time_range = intval($timecreate) + 300;

          if ($_GET['selector'] == "$selector" && $_GET['validator'] == "$validator" && $time_check_now <= $time_range) {
            if (isset($_GET['error'])) {
              if ($_GET['error'] == "empty") {
                echo '<div class="alert alert-danger error_show_width">
                Password or request password is empty!!!!
                </div>';
              }
              elseif ($_GET['error'] == "pwdnotsame") {
                echo '<div class="alert alert-danger error_show_width">
                  Password and request password not same!!
                </div>';
              }
              elseif ($_GET['error'] == "sql") {
                echo '<div class="alert alert-danger error_show_width">
                  The Database error!!
                </div>';
              }
              elseif ($_GET['error'] == "password_on_same") {
                echo '<div class="alert alert-danger error_show_width">
                 The password you want to create is the same as the current password!!
                </div>';
              }
            }
            ?>
              <form action="includes/reset-password.inc.php" method="post" class="form_default">
                <input type="hidden" name="selector" value="<?php echo $selector; ?>">
                <input type="hidden" name="validator" value="<?php echo $validator; ?>">
                <input type="password" name="pwd" placeholder = "Enter a new password..." class="form_config_input" required>
                <input type="password" name="pwd-repeat" placeholder ="Repeat new password..." class="form_config_input" required>
                <button type="submit" name="reset-password-submit" class="button_config">Create password</button>
              </form>
            <?php
          } else {
            header("location: ../url_not_found.php");
          }
        ?>
    </center>
</body>
</html>
<main>
</main>

