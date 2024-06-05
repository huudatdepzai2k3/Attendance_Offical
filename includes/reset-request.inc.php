<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

require '../connectDB.php';

 if(isset($_POST["reset-request-submit"])) {
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(16);
    $validator = bin2hex($token);

    $url = "172.20.10.2/attendance/create-new-password.php?selector=" . $selector . "&validator=" .$validator;

    $time_create = time();
    $id = "1";

    $userEmail = $_POST["email"];
    if (!filter_var($userEmail,FILTER_VALIDATE_EMAIL)) {
        header("location: ../reset-password.php?error=invalidEmail");
        exit();
    } else {
        $sql = "SELECT * FROM admin WHERE admin_email=?";
		$result = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($result, $sql)) {
			header("location: ../reset-password.php?error=sqlerror");
  			exit();
		} else{
			mysqli_stmt_bind_param($result, "s", $userEmail);
			mysqli_stmt_execute($result);
			$resultl = mysqli_stmt_get_result($result);
			if ($row = mysqli_fetch_assoc($resultl)) {
                $sql = "SELECT * FROM check_url";
                $result = mysqli_query($conn , $sql);

                if(mysqli_num_rows($result) < 1) {
                    $sql = "INSERT INTO check_url (id,selector_check, validator_check, time_create) VALUES (?, ?, ?, ?);";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "There was an error!";
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "ssss" ,$id,$selector, $validator, $time_create);
                        mysqli_stmt_execute($stmt);
                    }

                    mysqli_stmt_close($stmt);
                } else {
                    $sql = "UPDATE check_url SET selector_check = '$selector', validator_check = '$validator', time_create = '$time_create' WHERE id = 1";
                    mysqli_query($conn, $sql);
                }

            
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->isSMTP();                                       
                    $mail->Host       = 'smtp.gmail.com';                     
                    $mail->SMTPAuth   = true;                                   
                    $mail->Username   = 'ducluong19082003@gmail.com';                    
                    $mail->Password   = 'npqcawjsprunhqlr';                               
                    $mail->SMTPSecure = 'ssl';            
                    $mail->Port       = 465;                                   

                    //Recipients
                    $mail->setFrom('ducluong19082003@gmail.com', 'Admin_attendance');
                    $mail->addAddress("$userEmail", '');     
    
                    //Content
                    $mail->isHTML(true);                                  
                    $mail->Subject = 'Confirm reset password';
                    $mail->Body    = '<div style="margin: 0 100px;">
                                  <center><img src="https://th.bing.com/th/id/OIP.d07BNWOjejGOIPbvb_LNxgHaEK?w=303&h=180&c=7&r=0&o=5&dpr=1.3&pid=1.7" width="212px" height="74px"></br>
                                  <b style="font-size = 20px;font-style: italic;">Confirm reset password</b></center>
                                  <div style="border: 1px solid #ccc; border-radius: 10px; padding: 20px;margin: 10px 50px;"> We recieved a password reset request from you. The link to reset your password is below. If you did not make this request, you can ignore this email<a href="http://' .$url . '" style="text-decoration: none;"> Click Here </a> to create new password.</br>
                                  <p><b>Note:</b>This link is only available for 5 minutes</br></br>
                                  Thanks,</br>The Attendance teams</p></div></div>';
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    $mail->send();

                    header("Location: ../reset-password.php?reset=success");
                } catch (Exception $e) {
                    header("location: ../reset-password.php?error=send_mail");
                } 
            } else {
				header("location: ../reset-password.php?error=nouser");
  				exit();
            }
		}
    }
 } else {
    header("Location: ../index.php");
 }
?>