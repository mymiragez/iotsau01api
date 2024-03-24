<?php
// get_all_roomtemp_2_api.php
header("Access-Control-Allow-Origin: *");
// กำหนดเนื้อหาข้อมูลที่ใช้ในการรับส่งเป็น JSON และเข้ารหัสอักขระเป็น UTF-8
header("Content-Type: application/json; charset=UTF-8");

// เรียกใช้งานไฟล์ connectdb.php, roomtemp.php
require_once "./../../connectdb.php";
require_once "./../../models/roomtemp.php";

$connectDB = new ConnectDB();
$roomtemp = new Roomtemp($connectDB->createConnectionDB()); // สร้าง Connection DB

// เรียกใช้ฟังก์ชัน getAllTemp1()
$result = $roomtemp->getAllTemp2();

// กรณีที่การเรียกใช้ API ข้อมูลที่ส่งกลับมีโอกาสมากกว่า 1 Record/Row 
// ให้สร้างตัวแปร array เพื่อเก็บชุดข้อมูลทั้งหมด
$totalResultArray = array();

// ตรวจสอบผลที่ได้จากการ query ข้อมูลว่ามีข้อมูลหรือไม่
// ตรวจสอบว่า $result มีข้อมูลหรือไม่
if ($result->rowCount() > 0) {
    while ($resultData = $result->fetch(PDO::FETCH_ASSOC)) {
        // ดึงเฉพาะข้อมูล temp1 ออกมาเท่านั้น
        extract($resultData);
        $resultArray = array(
            "message" => "1",
            "roomtempId" => $roomtempId,
            "temp2" => strval($temp2),
            "datesave" => $datesave,
            "timesave" => $timesave
        );
        array_push($totalResultArray, $resultArray);
    }

    http_response_code(200);
    echo json_encode($totalResultArray, JSON_UNESCAPED_UNICODE);
} else {
    $resultArray = array(
        "message" => "0"
    );
    array_push($totalResultArray, $resultArray);
    http_response_code(200);
    echo json_encode($totalResultArray, JSON_UNESCAPED_UNICODE);
}
