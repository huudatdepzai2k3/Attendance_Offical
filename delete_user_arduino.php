<?php
   if(isset($_GET["fingerprint_id_delete"]) && isset($_GET["device_token"]) && isset($_GET["card_uid_delete"])) {
        $fingerprint_delete = $_GET['fingerprint_id_delete'];
        $device_uid = $_GET['device_token'];
        $card_delete = $_GET['card_uid_delete'];
        if (!empty($fingerprint_delete) && !empty($card_delete) && !empty($device_uid)){
            require 'connectDB.php';
        
            $sql = "SELECT * FROM `users` WHERE (fingerprint_id = '$fingerprint_delete' && device_uid = '$device_uid' && card_uid = '$card_delete')";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            if(!empty($row)){
                $sql = "DELETE FROM `users` WHERE (fingerprint_id = '$fingerprint_delete' && device_uid = '$device_uid' && card_uid = '$card_delete')";
                mysqli_query($conn,  $sql);
                echo "Delete user success";
            } else {
                echo "Not found user";
            }
        } else {
            echo "Conventional transmission parameter errors (delete user arduino)";
        }
    }
?>
