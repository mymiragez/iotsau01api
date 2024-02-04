<?php
//API ทำหน้าที่ รับ Request จาก Client เพื่อไป query(ดึง) ข้อมูลจาก database แล้ว Response ส่งกลับไปยัง Client
//กำหนดการเรียกใช้ข้าม Domain
header("Access-Control-Allow-Origin: *");
//กำหนดเนื้อหาข้อมูลที่ใช้ในการรับส่งเป็น JSON และเข้ารหัสอักขระเป็น UTF-8
header("Content-Type: application/json; charset=UTF-8");

//เรียกใช้งานไฟล์ connectdb.php, user.php
require_once "./../../connectdb.php"; //getuser อยู่ใน user ./ ออกจาก getuser ../ออกจากโฟร์เดอร์ user ../ ออกจาก apis ถึงจะเจอ connectdb.php
require_once "./../../models/roomtemp.php";

$connectDB = new ConnectDB();
$roomTemp = new roomTemp($connectDB->createConnectionDB()); //สร้าง Connection DB

//ตัวแปรเก็บค่าที่ส่งมาจากฝั่ง Client เอาข้อมูลที่ส่งมาเป็น json มา ถอดรหัส decode เพื่อใช้งาน
$data = json_decode(file_get_contents("php://input"));

$roomTemp->temp1 = $data->temp1;
$roomTemp->temp2 = $data->temp2;
$roomTemp->temp3 = $data->temp3;
$roomTemp->datesave = $data->datesave;
$roomTemp->timesave = $data->timesave;

//เรียกใช้ฟังก์ชั่น inserRoomTemp()
if ($roomTemp->insertRoomTemp()) {
    // insert สำเร็จ
    $resultArray = array(
        "message" => "1",
    );
    http_response_code(200);
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
} else {
        // insert ไม่สำเร็จ
    $resultArray = array(
        "message" => "0",
    );
    http_response_code(200);
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
};
