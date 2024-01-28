<?php
//ใช้ทำงานกับข้อมูล กับตาราง(Table):user_tb ในDatabase: iotsau_01_db
class User
{
    //ตัวแปรที่ใช้สำหรับการติดต่อกับ DB เพื่อมาใช้การทำงานกับ Table ใน DB
    private $connectDB;
    //สร้างตัวแปรที่ map กับ column ใน Table 
    public $user_id;
    public $user_fullname;
    public $user_name;
    public $user_password;
    public $user_age;

    public $message;

    //สร้าง Constructor เพื่อรับค่ามากำหนดให้กับตัวแปรที่ใช้สำหรับการติดต่อกับ DB
    public function __construct($connectDB)
    {
        $this->connectDB = $connectDB;
    }
    //เป็นส่วนของฟังก์ชั่นต่าง ๆ ตามวัตถุประสงค์การทำงานของแต่ละ API ที่จะทำงานกับตาราง User
    public function getUser()
    {
        //สร้างคำสั่ง  SQL
        $strSQL = "SELECT * FROM user_tb";

        //สร้าง Statement เพื่อใช้งานคำสั่ง SQL
        $stmt = $this->connectDB->prepare($strSQL);

        //สั่ง SQL ทำงานผ่าน Statement
        $stmt->execute();

        //ส่งค่ากลับผลลัพธ์จากการใช้งานคำสั่ง SQL
        return $stmt;
    }


    public function checkLoginUser (){}
    public function inserUesr (){}
    public function updateUsere(){}
}
