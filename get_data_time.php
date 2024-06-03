<?php
    $timestamp = time();
    date_default_timezone_set('Asia/Jakarta');
    $localtime = localtime($timestamp, true);
    $year = $localtime['tm_year'] + 1900;
    $month = $localtime['tm_mon'] + 1;
    $day = $localtime['tm_mday'];

    $hour = $localtime['tm_hour'];
    $minute = $localtime['tm_min'];
    $second = $localtime['tm_sec'];

    $data = array(
        'year' => $year,
        'month' => $month,
        'day' => $day,

        'hour' => $hour,
        'minute' => $minute,
        'second' => $second,
    );
    
    // Thiết lập header của trang để trả về JSON
    header('Content-Type: application/json');
    
    // Trả về dữ liệu dưới dạng JSON
    echo json_encode($data);
?>