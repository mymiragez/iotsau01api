<?php
//ใช้ทำงานกับข้อมูล กับ Table: roomtemp_tb ใน  Database: iot_sau01_db 
class Roomtemp
{
    //สร้างตัวแปรที่ใช้สำหรับการติดต่อกับ DB เพื่อมาใช้กับการทำงานกับ Table ใน DB
    private $connectDB;

    //สร้างตัวแปรที่แมปกับ column ใน table
    public $roomTempID;
    public $temp1;
    public $temp2;
    public $temp3;
    public $datesave;
    public $timesave;

    public $message; //ตัวแปรสารพัดประโยชน์

    //สร้าง Constructor เพื่อรับค่ามากำหนดให้กับตัวแปรที่ใช้สำหรับการติดต่อกับ DB
    public function __construct($connectDB)
    {
        $this->connectDB = $connectDB;
    }
    /// ฟังชั่นดึงข้อมูลทั้งหมด
    public function getAllTemp()
    {
        //สร้างคำสั่ง SQL
        $strSQL = "SELECT * FROM roomtemp_tb";

        //สร้าง Statement เพื่อใช้งานคำสั่ง SQL
        $stmt = $this->connectDB->prepare($strSQL);

        //สั่ง SQL ทำงานผ่าน Statement
        $stmt->execute();

        //ส่งค่ากลับผลลัพธ์จากการใช้งานคำสั่ง SQL
        return $stmt;
    }

    /// ฟังชั่นดึงข้อมูล getAllTemp1
    public function getAllTemp1()
    {
        //สร้างคำสั่ง SQL
        $strSQL = "SELECT roomtempId,temp1,datesave,timesave FROM roomtemp_tb";

        //สร้าง Statement เพื่อใช้งานคำสั่ง SQL
        $stmt = $this->connectDB->prepare($strSQL);

        //สั่ง SQL ทำงานผ่าน Statement
        $stmt->execute();

        //ส่งค่ากลับผลลัพธ์จากการใช้งานคำสั่ง SQL
        return $stmt;
    }

    /// ฟังชั่นดึงข้อมูล getAllTemp2
    public function getAllTemp2()
    {
        //สร้างคำสั่ง SQL
        $strSQL = "SELECT roomtempId,temp2,datesave,timesave FROM roomtemp_tb";

        //สร้าง Statement เพื่อใช้งานคำสั่ง SQL
        $stmt = $this->connectDB->prepare($strSQL);

        //สั่ง SQL ทำงานผ่าน Statement
        $stmt->execute();

        //ส่งค่ากลับผลลัพธ์จากการใช้งานคำสั่ง SQL
        return $stmt;
    }

    /// ฟังชั่นดึงข้อมูล getAllTemp3
    public function getAllTemp3()
    {
        //สร้างคำสั่ง SQL
        $strSQL = "SELECT roomtempId,temp3,datesave,timesave FROM roomtemp_tb";

        //สร้าง Statement เพื่อใช้งานคำสั่ง SQL
        $stmt = $this->connectDB->prepare($strSQL);

        //สั่ง SQL ทำงานผ่าน Statement
        $stmt->execute();

        //ส่งค่ากลับผลลัพธ์จากการใช้งานคำสั่ง SQL
        return $stmt;
    }

    //ฟังก์ชั่นดึงข้อมูลแอร์ตัวที่เลือก วันที่เลือกเพื่อแสดงเป็นกราฟ
    public function getAirDateForGraph()
    {
        $strSQL = "SELECT * FROM roomtemp_tb WHERE datesave = :datesave";

        //สร้าง Statement เพื่อใช้งานคำสั่ง SQL
        $stmt = $this->connectDB->prepare($strSQL);

        //ตรวจสอบค่าที่ส่งมาจาก Client ก่อนเพื่อที่จะกำหนดให้กับ Parameter ของ SQL
        $this->datesave = htmlspecialchars(strip_tags($this->datesave));

        //กำหนดค่าที่ส่งมาจาก Client ให้กับ Parameter ของ SQL
        $stmt->bindParam(":datesave", $this->datesave);

        //สั่ง SQL ทำงานผ่าน Statement
        $stmt->execute();

        //ส่งค่ากลับผลลัพธ์จากการใช้งานคำสั่ง SQL
        return $stmt;
    }
}
