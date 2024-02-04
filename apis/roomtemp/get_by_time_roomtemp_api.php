<?php
//API ทำหน้าที่ รับ Request จาก Client เพื่อไป query(ดึง) ข้อมูลจาก database แล้ว Response ส่งกลับไปยัง Client
//กำหนดการเรียกใช้ข้าม Domain
header("Access-Control-Allow-Origin: *");
//กำหนดเนื้อหาข้อมูลที่ใช้ในการรับส่งเป็น JSON และเข้ารหัสอักขระเป็น UTF-8
header("Content-Type: application/json; charset=UTF-8");


require_once "./../../connectdb.php";
require_once "./../../models/roomtemp.php";

$connectDB = new ConnectDB();
$roomTemp = new roomTemp($connectDB->createConnectionDB()); //สร้าง Connection DB

//ตัวแปรเก็บค่าที่ส่งมาจากฝั่ง Client เอาข้อมูลที่ส่งมาเป็น json มา ถอดรหัส decode เพื่อใช้งาน
$data = json_decode(file_get_contents("php://input"));

//เอาค่าที่เก็บในตัวแปรหลังจากการ decode มากำหนดให้กับตัวแปรที่ใช้กับฟังก์ชั่นที่ model
$roomTemp->timesave = $data->timesave;

//เรียกใช้ฟังก์ชั่น ()
$result = $roomTemp->getByTimeRoomtemp();

//ตรวจสอบว่า result มีข้อมูลหรือไม่
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
        array_push($jsonDataResult, $resultArray);
    }
    http_response_code(200);
    echo json_encode($jsonDataResult, JSON_UNESCAPED_UNICODE); // JSON_UNESCAPED_UNICODE แก้ภาษาไทยเพี้ยน
} else {
    //ไม่มีข้อมูล
    $resultArray = array(
        "message" => "0"
    );

    http_response_code(200);
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
}
