<?php
if(isset($_POST["conirm-change-submit"])) {
    $OTP_input = $_POST["OTP_in"];
    $time_now = time();

    require '../connectDB.php';
    $sql = "SELECT * FROM check_otp";
    $result = mysqli_query($conn , $sql);
    if(mysqli_num_rows($result) == 1) {
        while($row = mysqli_fetch_array($result)){
        $OTP_set = $row['otp_check'];
        $email_new_change = $row['email_change'];
        $OTP_timecreate = $row['time_create'];
        }
    } else {
        header("Location: ../change_email_2.php?error=sql");
    }
    
    // change string to integer
    $time_check_now = intval($time_now);
    $time_range_otp = intval($OTP_timecreate) + 300;

    if($time_check_now <= $time_range_otp) {
        if($OTP_input == $OTP_set) {
            $sql = "DELETE FROM check_otp WHERE id = 1";
            mysqli_query($conn,  $sql);
        
            $sql = "UPDATE admin SET admin_email = '$email_new_change' WHERE id = 1";
            mysqli_query($conn,$sql);
            header("Location: ../change_email_2.php?success=email_changed");
        } else {
            header("Location: ../change_email_2.php?error=otp_incorrect");
        }
    } else {
        header("Location: ../change_email.php?error=out_time_check");
    }
} else {
    header("Location: ../index.php");
}
