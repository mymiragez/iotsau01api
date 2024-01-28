<?php
//ไฟล์กลางทำหน้าที่เป็นไฟล์กลางติดต่อกับ Database
class ConnectDB
{
    //สร้างตัวแปรที่จะใช้ในการติดต่อกับ DB
    private $host = "localhost"; // Server Name (Host Name, Domain) ที่เก็บ DB ไว้
    private $uname = "root"; // username login DB
    private $pword = ""; //password login DB
    private $dbname = "iotsau_01_db"; //Database Name


    //ตัวแปรที่ใช้สำหรับติดต่อกับฐานข้อมูล
    public $connDB;

    //ฟังก์ชั่นที่ใช้สำหรับติดต่อไปยัง DB
    public function createConnectionDB()
    {
        $this->connDB = null;

        try {
            //คำสั่งติดต่อกับ DB
            $this->connDB = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname}",$this->uname,$this->pword //เปลี่ยนตามตัวที่ใช้งาน

            );
           // echo "Connection OK";

        } catch (PDOException $ex) {
           // echo "Connection NOT OK";

        }

        //ส่งผลการติดต่อ DB ไปยังจุดที่เรียกใช้
        return $this->connDB;
    }
}
