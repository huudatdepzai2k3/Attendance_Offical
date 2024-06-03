<?php
session_start();
if (isset($_SESSION['Admin-name'])) {
  header("location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Log In</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="icons/humg-logo.png" >

    <link rel="stylesheet" type="text/css" href="css/css_main.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <script src="js/jquery-2.2.3.min.js"></script>
    <script>
      $(window).on("load resize ", function() {
          var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
          $('.tbl-header').css({'padding-right':scrollWidth});
      }).resize();
    </script>
    <script type="text/javascript">
      $(document).ready(function(){
        $(document).on('click', '.message', function(){
          $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
          $('h1').animate({height: "toggle", opacity: "toggle"}, "slow");
        });
      });
    </script>
</head>
<body>
<?php include'header.php'; ?> 
<main>
  <h1 class="slideInDown animated">Please, Login with the Admin E-mail and Password</h1>
  <h1 class="slideInDown animated" id="reset">Please, Enter your Email to send the reset password link</h1>
<!-- Log In -->
<section>
  <center class="slideInDown animated">
    <div class="login-page">
        <?php  
          if (isset($_GET['error'])) {
            if ($_GET['error'] == "invalidEmail") {
                echo '<div class="alert alert-danger">
                  This E-mail is invalid!!
                </div>';
            }
            elseif ($_GET['error'] == "sqlerror") {
                echo '<div class="alert alert-danger">
                  There a database error!!
                </div>';
            }
            elseif ($_GET['error'] == "wrongpassword") {
                echo '<div class="alert alert-danger">
                    Wrong password!!
                  </div>';
            }
            elseif ($_GET['error'] == "nouser") {
                echo '<div class="alert alert-danger">
                    This E-mail does not exist!!
                  </div>';
            }
          }
        ?>
        <div class="alert1"></div> 
        <form action="ac_login.php" class="login__form" method="post" enctype="multipart/form-data">
          <div class="login__content">
            <div class="login__box">
              <i class="ri-user-3-line login__icon"></i>

              <div class="login__box-input">
                <input type="email" required class="login__input" id="login-email" placeholder=" " name="email" id="email">
                <label for="login-email" class="login__label">Email</label>
              </div>
            </div>

            <div class="login__box">
              <i class="ri-lock-2-line login__icon"></i>

              <div class="login__box-input">
                <input type="password" required class="login__input" id="login-pass" placeholder=" " type="password" name="pwd" id="pwd">
                <label for="login-pass" class="login__label">Password</label>
                <i class="ri-eye-off-line login__eye" id="login-eye"></i>
              </div>
               </div>
            </div>
            
            <?php 
            if(isset($_GET["newpwd_reset"])) {
              if($_GET["newpwd_reset"] == "passwordupdated") {
                echo '<p class="success_notifi"> Your password has been reset!!</p>';
              }
            } 
            ?>
            <button type="submit" class="login__button" name="login" id="login">Login</button>

            <p class="message">Forgot your Password?<a href="reset-password.php">Reset your password</a></p>
         </form>
    </div>
  </center>
</section>
</main>
</body>
</html>