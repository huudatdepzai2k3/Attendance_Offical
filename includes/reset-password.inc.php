<?php
if(isset($_POST["reset-password-submit"])) {
    $selector = $_POST["selector"];
    $validator = $_POST["validator"];

    $passwordNew = $_POST["pwd"];
    $passwordNewRepeat = $_POST["pwd-repeat"];

    if ($passwordNew == $passwordNewRepeat) {
        require '../connectDB.php';

        $sql = "SELECT * FROM admin";
        $result = mysqli_query($conn , $sql);
        if(mysqli_num_rows($result) == 1) {
            while($row = mysqli_fetch_array($result)){
                $password_recent = $row['admin_pwd'];
            }
        } else {
            header("Location: ../create-new-password.php?selector=$selector&validator=$validator&error=sql");
        }
    
        $check = password_verify($passwordNew, $password_recent);
        if ($check == true) {
            header("Location: ../create-new-password.php?selector=$selector&validator=$validator&error=password_on_same");
        } else {
            $sql = "DELETE FROM check_url WHERE selector_check='$selector'";
            mysqli_query($conn,  $sql);
        
            $newPwdHash = password_hash($passwordNew, PASSWORD_DEFAULT);
            $sql = "UPDATE admin SET admin_pwd = '$newPwdHash' WHERE id = 1";
            mysqli_query($conn,$sql);
            header("Location: ../login.php?newpwd_reset=passwordupdated");
        }
    } else {
        header("Location: ../create-new-password.php?selector=$selector&validator=$validator&error=pwdnotsame");
        exit();
    }
} else {
    header("Location: ../index.php");
}