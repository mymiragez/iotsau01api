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

//เรียกใช้ฟังก์ชั่น getUser()
$result = $roomTemp->getAllRoomtemp();


//ตรวจสอบผลที่ได้จากการ query ข้อมูลว่ามีข้อมูลหรือไม่
if ($result->rowCount() > 0) {
    $jsonDataResult = array();
    //มีข้อมูล
    while ($resultData = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($resultData);
        $resultArray = array(
            "message" => "1",
            "roomtemp_id" => strval($roomtemp_id),
            "temp1" => $temp1,
            "temp2" => $temp2,
            "temp3" => $temp3,
            "datesave" => strval($datesave),
            "timesave" => strval($timesave)
        );
        //ehco $resultArray[0];
        array_push($jsonDataResult, $resultArray);
    }
    http_response_code(200);
    echo json_encode($jsonDataResult);
} else {
    //ไม่มีข้อมูล
    $jsonDataResult = array();
    $resultArray = array(
        "message" => "0"
    );
    array_push($jsonDataResult, $resultArray);

    http_response_code(200);
    echo json_encode($jsonDataResult);
}
