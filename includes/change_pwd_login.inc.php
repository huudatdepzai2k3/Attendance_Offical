<?php
if(isset($_POST["button-change-submit"])) {
    $passwordNew = $_POST["pwd_new"];
    $passwordNewRepeat = $_POST["pwd_new_repeat"];
    $passwordRecently = $_POST["pwd_recently"];

    if ($passwordNew == $passwordNewRepeat) {
        require '../connectDB.php';

        $sql = "SELECT * FROM admin";
        $result = mysqli_query($conn , $sql);
        if(mysqli_num_rows($result) == 1) {
            while($row = mysqli_fetch_array($result)){
                $password_recent = $row['admin_pwd'];
            }
        } else {
            header("Location: ../change_password.php?error=sql");
        }
    
        $check = password_verify($passwordRecently, $password_recent);
        if ($check == true) {
            if (password_verify($passwordNew, $password_recent)){
                header("Location: ../change_password.php?error=password_o_n_same");
            } else {
                $newPwdHash = password_hash($passwordNew, PASSWORD_DEFAULT);
                $sql = "UPDATE admin SET admin_pwd = '$newPwdHash' WHERE id = 1";
                mysqli_query($conn,$sql);
                header("Location: ../change_password.php?new_change=passwordupdated");
            }
        } else {
            header("Location: ../change_password.php?error=password_false");
        }
    } else {
        header("Location: ../change_password.php?error=pwdnotsame");
        exit();
    }
} else {
    header("Location: ../index.php");
}