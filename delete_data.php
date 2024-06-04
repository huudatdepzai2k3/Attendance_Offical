<?php
//Connect to database
require'connectDB.php';

$output = '';

if(isset($_POST["To_Delete"])){
  
    $searchQuery = " ";
    $Start_date = " ";
    $End_date = " ";
    $Start_time = " ";
    $End_time = " ";
    $card_sel = " ";

    //Start date filter
    if ($_POST['date_sel_start'] != 0) {
        $Start_date = $_POST['date_sel_start'];
        $_SESSION['searchQuery'] = "checkindate='".$Start_date."'";
    }
    else{
        $Start_date = date("Y-m-d");
        $_SESSION['searchQuery'] = "checkindate='".date("Y-m-d")."'";
    }
    //End date filter
    if ($_POST['date_sel_end'] != 0) {
        $End_date = $_POST['date_sel_end'];
        $_SESSION['searchQuery'] = "checkindate BETWEEN '".$Start_date."' AND '".$End_date."'";
    }
    //Time-In filter
    if ($_POST['time_sel'] == "Time_in") {
      //Start time filter
      if ($_POST['time_sel_start'] != 0 && $_POST['time_sel_end'] == 0) {
          $Start_time = $_POST['time_sel_start'];
          $_SESSION['searchQuery'] .= " AND timein='".$Start_time."'";
      }
      elseif ($_POST['time_sel_start'] != 0 && $_POST['time_sel_end'] != 0) {
          $Start_time = $_POST['time_sel_start'];
      }
      //End time filter
      if ($_POST['time_sel_end'] != 0) {
          $End_time = $_POST['time_sel_end'];
          $_SESSION['searchQuery'] .= " AND timein BETWEEN '".$Start_time."' AND '".$End_time."'";
      }
    }
    //Time-out filter
    if ($_POST['time_sel'] == "Time_out") {
      //Start time filter
      if ($_POST['time_sel_start'] != 0 && $_POST['time_sel_end'] == 0) {
          $Start_time = $_POST['time_sel_start'];
          $_SESSION['searchQuery'] .= " AND timeout='".$Start_time."'";
      }
      elseif ($_POST['time_sel_start'] != 0 && $_POST['time_sel_end'] != 0) {
          $Start_time = $_POST['time_sel_start'];
      }
      //End time filter
      if ($_POST['time_sel_end'] != 0) {
          $End_time = $_POST['time_sel_end'];
          $_SESSION['searchQuery'] .= " AND timeout BETWEEN '".$Start_time."' AND '".$End_time."'";
      }
    }
    //Card filter
    if ($_POST['card_sel'] != 0) {
        $card_sel = $_POST['card_sel'];
        $_SESSION['searchQuery'] .= " AND card_uid='".$card_sel."'";
    }
    //Department filter
    if ($_POST['dev_sel'] != 0) {
        $dev_uid = $_POST['dev_sel'];
        $_SESSION['searchQuery'] .= " AND device_uid='".$dev_uid."'";
    }

    $sql = "SELECT * FROM users_logs WHERE ".$_SESSION['searchQuery']." ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
    if($result->num_rows > 0){
        while($row=$result->fetch_assoc()) {
            $id_delete = $row['id'];
            $sql = "DELETE FROM users_logs WHERE id = $id_delete";
            mysqLi_query($conn, $sql);
        }
        header( "location:./UsersLog.php?delete_data_user_log=success");
        exit();
    }
    else{
      header( "location: UsersLog.php" );
      exit();
    }
}
?>