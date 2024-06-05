<?php  
//Connect to database
require 'connectDB.php';
date_default_timezone_set('Asia/Jakarta');
$d = date("Y-m-d");
$t = date("H:i:sa");

if (isset($_GET['card_uid']) && isset($_GET['fingerprint_id']) && isset($_GET['device_token'])) {
    
    $card_uid = $_GET['card_uid'];
    $fingerprint_id = $_GET['fingerprint_id'];
    $device_uid = $_GET['device_token'];

    $sql = "SELECT * FROM devices WHERE device_uid=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "SQL_Error_Select_device";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt, "s", $device_uid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)){
            $device_mode = $row['device_mode'];
            $device_dep = $row['device_dep'];
            if ($device_mode == 1) {
                if(empty($fingerprint_id) && !empty($card_uid)){
                    $sql = "SELECT * FROM users WHERE card_uid=?";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "SQL_Error_Select_card";
                        exit();
                    }
                    else{
                        mysqli_stmt_bind_param($stmt, "s", $card_uid);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if ($row = mysqli_fetch_assoc($result)){
                            //*****************************************************
                            //An existed Card has been detected for Login or Logout
                            if ($row['add_card'] == 1){
                                if ($row['device_uid'] == $device_uid || $row['device_uid'] == 0){
                                    $Uname = $row['username'];
                                    $Number = $row['serialnumber'];
                                    $fingerprint_id = $row['fingerprint_id'];

                                    $sql = "SELECT * FROM users_logs WHERE card_uid=? AND checkindate=? AND card_out=0";
                                    $stmt = mysqli_stmt_init($conn);
                                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                                        echo "SQL_Error_Select_logs";
                                        exit();
                                    }
                                    else{
                                        mysqli_stmt_bind_param($stmt, "ss", $card_uid, $d);
                                        mysqli_stmt_execute($stmt);
                                        $result = mysqli_stmt_get_result($stmt);
                                        //*****************************************************
                                        //Login
                                        if (!$row = mysqli_fetch_assoc($result)){
    
                                            $sql = "INSERT INTO users_logs (username, serialnumber, card_uid, fingerprint_id, device_uid, device_dep, checkindate, timein, checkoutdate, timeout) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                                            $stmt = mysqli_stmt_init($conn);
                                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                                echo "SQL_Error_Select_login1";
                                                exit();
                                            }
                                            else{
                                                $timeout = "00:00:00";
                                                $checkoutdate = "0000-00-00";
                                                mysqli_stmt_bind_param($stmt, "sdssssssss", $Uname, $Number, $card_uid, $fingerprint_id, $device_uid, $device_dep, $d, $t, $checkoutdate, $timeout);
                                                mysqli_stmt_execute($stmt);
    
                                                
                                                $data = array(
                                                    'Username' => $Uname,
                                                    'SerialNumber' => $Number,
                                                    'Condition' => "login"
                                                );
                                                
                                                // Thiết lập header của trang để trả về JSON
                                                header('Content-Type: application/json');
                                                
                                                // Trả về dữ liệu dưới dạng JSON
                                                echo json_encode($data);
                                                exit();
                                            }
                                        }
                                        //*****************************************************
                                        //Logout
                                        else{
                                            $sql="UPDATE users_logs SET timeout=?, checkoutdate=?, card_out=1 WHERE card_uid=? AND card_out=0";
                                            $stmt = mysqli_stmt_init($conn);
                                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                                echo "SQL_Error_insert_logout1";
                                                exit();
                                            }
                                            else{
                                                mysqli_stmt_bind_param($stmt, "sss", $t, $d, $card_uid);
                                                mysqli_stmt_execute($stmt);
    
                                                
                                                $data = array(
                                                    'Username' => $Uname,
                                                    'SerialNumber' => $Number,
                                                    'Condition' => "logout"
                                                );
                                                
                                                // Thiết lập header của trang để trả về JSON
                                                header('Content-Type: application/json');
                                                
                                                // Trả về dữ liệu dưới dạng JSON
                                                echo json_encode($data);
                                                exit();
                                            }
                                        }
                                    }
                                }
                                else {
                                    echo "Not Allowed!";
                                    exit();
                                }
                            }
                            else if ($row['add_card'] == 0){
                                echo "Not registered!";
                                exit();
                            }
                        }
                        else{
                            echo "Not found!";
                            exit();
                        }
                    }
                } else if (!empty($fingerprint_id) && empty($card_uid)) {
                    $sql = "SELECT * FROM users WHERE fingerprint_id=?";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "SQL_Error_Select_card";
                        exit();
                    }
                    else{
                        mysqli_stmt_bind_param($stmt, "s", $fingerprint_id);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if ($row = mysqli_fetch_assoc($result)){
                            //*****************************************************
                            //An existed fingerprint has been detected for Login or Logout
                            if ($row['add_card'] == 1){
                                if ($row['device_uid'] == $device_uid || $row['device_uid'] == 0){
                                    $Uname = $row['username'];
                                    $Number = $row['serialnumber'];
                                    $card_uid = $row['card_uid'];

                                    $sql = "SELECT * FROM users_logs WHERE fingerprint_id=? AND checkindate=? AND card_out=0";
                                    $stmt = mysqli_stmt_init($conn);
                                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                                        echo "SQL_Error_Select_logs";
                                        exit();
                                    }
                                    else{
                                        mysqli_stmt_bind_param($stmt, "ss", $fingerprint_id, $d);
                                        mysqli_stmt_execute($stmt);
                                        $result = mysqli_stmt_get_result($stmt);
                                        //*****************************************************
                                        //Login
                                        if (!$row = mysqli_fetch_assoc($result)){
    
                                            $sql = "INSERT INTO users_logs (username, serialnumber, card_uid, fingerprint_id, device_uid, device_dep, checkindate, timein, checkoutdate, timeout) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                                            $stmt = mysqli_stmt_init($conn);
                                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                                echo "SQL_Error_Select_login1";
                                                exit();
                                            }
                                            else{
                                                $timeout = "00:00:00";
                                                $checkoutdate = "0000-00-00";
                                                mysqli_stmt_bind_param($stmt, "sdssssssss", $Uname, $Number, $card_uid, $fingerprint_id, $device_uid, $device_dep, $d, $t, $checkoutdate, $timeout);
                                                mysqli_stmt_execute($stmt);
    
                                                    $data = array(
                                                        'Username' => $Uname,
                                                        'SerialNumber' => $Number,
                                                        'Condition' => "login"
                                                    );
                                                    
                                                    // Thiết lập header của trang để trả về JSON
                                                    header('Content-Type: application/json');
                                                    
                                                    // Trả về dữ liệu dưới dạng JSON
                                                    echo json_encode($data);
                                                exit();
                                            }
                                        }
                                        //*****************************************************
                                        //Logout
                                        else{
                                            $sql="UPDATE users_logs SET timeout=?, checkoutdate=?, card_out=1 WHERE fingerprint_id=? AND card_out=0";
                                            $stmt = mysqli_stmt_init($conn);
                                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                                echo "SQL_Error_insert_logout1";
                                                exit();
                                            }
                                            else{
                                                mysqli_stmt_bind_param($stmt, "sss", $t, $d, $fingerprint_id);
                                                mysqli_stmt_execute($stmt);
    
                                                $data = array(
                                                    'Username' => $Uname,
                                                    'SerialNumber' => $Number,
                                                    'Condition' => "logout"
                                                );
                                                header('Content-Type: application/json');
                                                echo json_encode($data);
                                                exit();
                                            }
                                        }
                                    }
                                }
                                else {
                                    echo "Not Allowed!";
                                    exit();
                                }
                            }
                            else if ($row['add_card'] == 0){
                                echo "Not registered!";
                                exit();
                            }
                        }
                        else{
                            echo "Not found!";
                            exit();
                        }
                    }
                } else {
                    echo "Conventional transmission parameter errors (Attendance)";
                }
            }
            else if ($device_mode == 0) {
                $sql = "SELECT * FROM users WHERE fingerprint_id= -1";
                $result = mysqli_query($conn, $sql);
                $num_row_no_finger = mysqli_num_rows($result);
                if (empty($fingerprint_id) && !empty($card_uid)) {
                    //New Card has been added
                    $sql = "SELECT * FROM users WHERE card_uid=?";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "SQL_Error_Select_card";
                        exit();
                    }
                    else{
                        mysqli_stmt_bind_param($stmt, "s", $card_uid);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        //The Card is available
                        if ($row = mysqli_fetch_assoc($result)){
                            $sql = "SELECT card_select FROM users WHERE card_select=1";
                            $stmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                echo "SQL_Error_Select";
                                exit();
                            } else{
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                
                                if ($row = mysqli_fetch_assoc($result)) {
                                    $sql="UPDATE users SET card_select=0";
                                    $stmt = mysqli_stmt_init($conn);
                                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                                        echo "SQL_Error_insert";
                                        exit();
                                    }
                                    else{
                                        mysqli_stmt_execute($stmt);
    
                                        $sql="UPDATE users SET card_select=1 WHERE card_uid=?";
                                        $stmt = mysqli_stmt_init($conn);
                                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                                            echo "SQL_Error_insert_An_available_card";
                                            exit();
                                        }
                                        else{
                                            mysqli_stmt_bind_param($stmt, "s", $card_uid);
                                            mysqli_stmt_execute($stmt);
    
                                            echo "available card_uid";
                                            exit();
                                        }
                                    }
                                }
                                else{
                                    $sql="UPDATE users SET card_select=1 WHERE card_uid=?";
                                    $stmt = mysqli_stmt_init($conn);
                                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                                        echo "SQL_Error_insert_An_available_card";
                                        exit();
                                    }
                                    else{
                                        mysqli_stmt_bind_param($stmt, "s", $card_uid);
                                        mysqli_stmt_execute($stmt);
    
                                        echo "available card_uid";
                                        exit();
                                    }
                                }
                            }
                        }
                        //The Card is new
                        else{
                            $sql="UPDATE users SET card_select=0";
                            $stmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                echo "SQL_Error_insert";
                                exit();
                            }
                            else{
                                mysqli_stmt_execute($stmt);
                                if ($num_row_no_finger == 0) {
                                    $sql = "INSERT INTO users (card_uid, fingerprint_id, card_select, device_uid, device_dep, user_date) VALUES (?, ?, 1, ?, ?, CURDATE())";
                                    $stmt = mysqli_stmt_init($conn);
                                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                                        echo "SQL_Error_Select_add";
                                        exit();
                                    }
                                    else{
                                        $fingerprint_id = -1;
                                        mysqli_stmt_bind_param($stmt, "ssss", $card_uid, $fingerprint_id, $device_uid, $device_dep);
                                        mysqli_stmt_execute($stmt);
                                        
                                        echo "successful";
                                        exit();
                                    }
                                } else {
                                    $sql = "UPDATE users SET card_uid = '$card_uid' WHERE fingerprint_id= -1";
                                    mysqLi_query($conn , $sql);
                                    
                                    echo "successful";
                                    exit();
                                }
                            }
                        }
                    }
                } else if (!empty($fingerprint_id) && empty($card_uid)){
                    if($num_row_no_finger == 1){
                        $sql = "SELECT * FROM users WHERE fingerprint_id= $fingerprint_id";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) == 0){
                            $sql = "UPDATE users SET fingerprint_id = $fingerprint_id WHERE fingerprint_id= -1";
                            mysqLi_query($conn , $sql);
                            echo "successful";
                        } else {
                            echo "available fingerprint";
                        }
                    } else {
                        echo "error";
                    }
                } else {
                    echo "Conventional transmission parameter errors (Add id)"; 
                } 
            }
        }
        else{
            echo "Invalid Device!";
            exit();
        }
    }          
}
?>
