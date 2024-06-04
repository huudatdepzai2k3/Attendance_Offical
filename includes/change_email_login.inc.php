<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';


if(isset($_POST["button-change-submit"])) {
    $emailNew = $_POST["email_new"];
    $passwordRecentInput = $_POST["pwd_recently"];
    
    require '../connectDB.php';
    
    $sql = "SELECT * FROM admin";
    $result = mysqli_query($conn , $sql);
    if(mysqli_num_rows($result) == 1) {
        while($row = mysqli_fetch_array($result)){
            $email_recent = $row['admin_email'];
            $password_recent = $row['admin_pwd'];
        }
    } else {
        header("Location: ../change_email.php?error=sql");
    }
    
    $pwd_check = password_verify($passwordRecentInput, $password_recent);
2    if($pwd_check == true) {
        if($emailNew != $email_recent){
            $otp = bin2hex(random_bytes(8));
            $time_create = time();
            $id = "1";

            // add otp and create time to database
            $sql = "SELECT * FROM check_otp";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) < 1) {
                $sql = "INSERT INTO check_otp (id, otp_check, email_change, time_create) VALUES (?, ?, ?, ?);";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "There was an error!";
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "ssss", $id, $otp, $emailNew, $time_create);
                    mysqli_stmt_execute($stmt);
                }

                mysqli_stmt_close($stmt);
            } else {
                $sql = "UPDATE check_otp SET otp_check = '$otp', time_create = '$time_create',email_change = '$emailNew' WHERE id = 1";
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
                $mail->addAddress("$emailNew ", '');     

                //Content
                $mail->isHTML(true);                                  
                $mail->Subject = 'Confirm new email login change';
                $mail->Body    = '<div style="margin: 0 100px;">
                                  <center><img src="https://th.bing.com/th/id/OIP.d07BNWOjejGOIPbvb_LNxgHaEK?w=303&h=180&c=7&r=0&o=5&dpr=1.3&pid=1.7" width="212px" height="74px"></br>
                                  <b style="font-size = 20px;font-style: italic;">Confirm change email login</b></center>
                                  <div style="border: 1px solid #ccc; border-radius: 10px; padding: 20px;margin: 10px 50px;">We received an email change request from you. To confirm the email change request, please copy the OTP below:</br>
                                  <center style="margin: 10px;"><b style="color: #78ff07">'. $otp .'</b></center>
                                  <p><b>Note:</b> This OTP is only available for 5 minutes</br></br>
                                  Thanks,</br>The Attendance teams</p></div></div>';
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();

                header("Location: ../change_email_2.php");
            } catch (Exception $e) {
                header("location: ../change_email.php?error=send_mail");
            } 
        } else {
            header("location: ../change_email.php?error=emails_same");
        }
    } else {
        header("location: ../change_email.php?error=pwd_incorrect");
    }
} else {
    header("Location: ../index.php");
}