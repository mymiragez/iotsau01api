<?php
//API ทำหน้าที่ รับ Request จาก Client เพื่อนำข้อมูลที่ Client ส่งมาไปบันทึกใน database แล้ว Response ส่งกลับไปยัง Client ว่าบันทึกเรียบร้อยแล้ว
//API ทำหน้าที่ รับ Request จาก Client เพื่อไป query(ดึง) ข้อมูลจาก database แล้ว Response ส่งกลับไปยัง Client
//กำหนดการเรียกใช้ข้าม Domain
header("Access-Control-Allow-Origin: *");
//กำหนดเนื้อหาข้อมูลที่ใช้ในการรับส่งเป็น JSON และเข้ารหัสอักขระเป็น UTF-8
header("Content-Type: application/json; charset=UTF-8");

//เรียกใช้งานไฟล์ connectdb.php, user.php
require_once "./../../connectdb.php"; //getuser อยู่ใน user ./ ออกจาก getuser ../ออกจากโฟร์เดอร์ user ../ ออกจาก apis ถึงจะเจอ connectdb.php
require_once "./../../models/user.php";

$connectDB = new ConnectDB();
$user = new User($connectDB->createConnectionDB()); //สร้าง Connection DB

//ตัวแปรเก็บค่าที่ส่งมาจากฝั่ง Client เอาข้อมูลที่ส่งมาเป็น json มา ถอดรหัส decode เพื่อใช้งาน
$data = json_decode(file_get_contents("php://input"));

//เอาค่าที่เก็บในตัวแปรหลังจากการ decode มากำหนดให้กับตัวแปรที่ใช้กับฟังก์ชั่นที่ model
$user->user_id = $data->user_id;

//เรียกใช้ฟังก์ชั่น deleteUser()
if ($user->deleteUser()) {
    // delete สำเร็จ
    $resultArray = array(
        "message" => "1",
    );
    http_response_code(200);
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
} else {
        // delete ไม่สำเร็จ
    $resultArray = array(
        "message" => "0",
    );
    http_response_code(200);
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
};
