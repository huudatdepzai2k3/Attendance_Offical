<?php 
  if(isset($_GET["serialnumber_user"]) && isset($_GET["device_token"])) {
    $serialnumber_user = $_GET['serialnumber_user'];
    $device_uid = $_GET['device_token'];
    if (!empty($serialnumber_user) && !empty($device_uid)){
      require "connectDB.php";
      $sql = "SELECT * FROM `users` WHERE (serialnumber = '$serialnumber_user' && device_uid = '$device_uid')";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_assoc($result);
      if(!empty($row)){
        $data = array (
          'username' =>  $row['username'],
          'serialnumber' =>  $row['serialnumber'],
          'gender' =>  $row['gender'],
          'card_uid' =>  $row['card_uid'],
          'fingerprint_id' =>  $row['fingerprint_id'],
        );
        
        $result->close();
        $conn->close();
        header('Content-Type: application/json');
        echo json_encode($data);
      } else {
        echo "not found serial number";
      }

    } else {
      echo "wrong transmission structure (Check serial number)";
    }
  }
?>