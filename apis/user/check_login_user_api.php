<?php
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
$user->user_name = $data->user_name;
$user->user_password = $data->user_password;

//เรียกใช้ฟังก์ชั่น checkLoginUser()
$result = $user->checkLoginUser();

//ตรวจสอบว่า result มีข้อมูลหรือไม่
if ($result->rowCount() > 0) {
    //มีข้อมูล User/Password ถูกต้อง
    //จะส่งค่าชื่อและอายุกลับไป
    $resultData = $result->fetch(PDO::FETCH_ASSOC);
    extract($resultData);
    $resultArray = array(
        "message" => "1",
        "user_id" => strval($user_id),
        "user_fullname" => $user_fullname,
        "user_age" => strval($user_age)
    );
    http_response_code(200);
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE); // JSON_UNESCAPED_UNICODE แก้ภาษาไทยเพี้ยน
} else {
    //ไม่มีข้อมูล User/Password ไม่ถูกต้อง
    $resultArray = array(
        "message" => "0"
    );
    http_response_code(200);
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
}
