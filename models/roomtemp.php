<?php
//ใช้ทำงานกับข้อมูล กับตาราง(Table):roomtemp_tb ในDatabase: iotsau_01_db
class roomTemp
{
    //ตัวแปรที่ใช้สำหรับการติดต่อกับ DB เพื่อมาใช้การทำงานกับ Table ใน DB******
    private $connectDB;
    //สร้างตัวแปรที่ map กับ column ใน Table 
    public $roomtemp_id;
    public $temp1;
    public $temp2;
    public $temp3;
    public $datesave;
    public $timesave;
    public $startDate;
    public $endDate;

    public $message; //ตัวแปรสารพัดประโยชน์ ****

    //สร้าง Constructor เพื่อรับค่ามากำหนดให้กับตัวแปรที่ใช้สำหรับการติดต่อกับ DB*****
    public function __construct($connectDB)
    {
        $this->connectDB = $connectDB;
    }
    //เป็นส่วนของฟังก์ชั่นต่าง ๆ ตามวัตถุประสงค์การทำงานของแต่ละ API ที่จะทำงานกับตาราง roomTemp
    public function getAllRoomtemp()
    {
        //สร้างคำสั่ง  SQL
        $strSQL = "SELECT * FROM roomtemp_tb";

        //สร้าง Statement เพื่อใช้งานคำสั่ง SQL
        $stmt = $this->connectDB->prepare($strSQL);

        //สั่ง SQL ทำงานผ่าน Statement
        $stmt->execute();

        //ส่งค่ากลับผลลัพธ์จากการใช้งานคำสั่ง SQL
        return $stmt;
    }
    public function insertRoomTemp()
    {
        $strSQL = "INSERT INTO roomtemp_tb (temp1, temp2, temp3, datesave,timesave) VALUES (:temp1, :temp2, :temp3, :datesave, :timesave)";

        $stmt = $this->connectDB->prepare($strSQL);

        //ตรวจสอบค่าที่ส่งมาจาก Client ก่อนเพื่อกำหนดให้กับ parameter ของ  SQL
        $this->temp1 = doubleval(htmlspecialchars(strip_tags($this->temp1)));
        $this->temp2 = doubleval(htmlspecialchars(strip_tags($this->temp2)));
        $this->temp3 = doubleval(htmlspecialchars(strip_tags($this->temp3)));
        $this->datesave = date('Y-m-d', strtotime(htmlspecialchars(strip_tags($this->datesave)))); 
        $this->timesave = date('H:i:s', strtotime(htmlspecialchars(strip_tags($this->timesave))));


        //กำหนดค่าที่ส่งมาจาก Client ให้กับ Parameter ของ SQL
        $stmt->bindParam(":temp1", $this->temp1);
        $stmt->bindParam(":temp2", $this->temp2);
        $stmt->bindParam(":temp3", $this->temp3);
        $stmt->bindParam(":datesave", $this->datesave);
        $stmt->bindParam(":timesave", $this->timesave);

        //สั่ง SQL ให้ทำงานผ่าน Statement
        if ($stmt->execute()) {
            //insert สำเร็จ
            return true;
        } else {
            //insert ไม่สำเร็จ
            return false;
        }   
    }

    public function getByDateRoomtemp()
    {
        //สร้างคำสั่ง  SQL
        $strSQL = "SELECT * FROM roomtemp_tb WHERE datesave = :datesave";

        //สร้าง Statement เพื่อใช้งานคำสั่ง SQL
        $stmt = $this->connectDB->prepare($strSQL);

        $this->datesave = date('Y-m-d', strtotime(htmlspecialchars(strip_tags($this->datesave)))); 

        $stmt->bindParam(":datesave", $this->datesave);

        //สั่ง SQL ทำงานผ่าน Statement
        $stmt->execute();

        //ส่งค่ากลับผลลัพธ์จากการใช้งานคำสั่ง SQL
        return $stmt;
    }

    public function getByTimeRoomtemp()
    {
        //สร้างคำสั่ง  SQL
        $strSQL = "SELECT * FROM roomtemp_tb WHERE timesave = :timesave";

        //สร้าง Statement เพื่อใช้งานคำสั่ง SQL
        $stmt = $this->connectDB->prepare($strSQL);

        $this->timesave = date('H:i:s', strtotime(htmlspecialchars(strip_tags($this->timesave))));

        $stmt->bindParam(":timesave", $this->timesave);

        //สั่ง SQL ทำงานผ่าน Statement
        $stmt->execute();

        //ส่งค่ากลับผลลัพธ์จากการใช้งานคำสั่ง SQL
        return $stmt;
    }
    
    public function getByDateBetweenRoomtemp()
    {
        // สร้างคำสั่ง SQL
        $strSQL = "SELECT * FROM roomtemp_tb WHERE datesave BETWEEN :startDate AND :endDate";
    
        // สร้าง Statement เพื่อใช้งานคำสั่ง SQL
        $stmt = $this->connectDB->prepare($strSQL);
    
        // ปรับปรุงรูปแบบวันที่
        $this->startDate = date('Y-m-d', strtotime(htmlspecialchars(strip_tags($this->startDate))));
        $this->endDate = date('Y-m-d', strtotime(htmlspecialchars(strip_tags($this->endDate))));
    
        // กำหนดค่า parameter
        $stmt->bindParam(":startDate", $this->startDate);
        $stmt->bindParam(":endDate", $this->endDate);
    
        // สั่ง SQL ทำงานผ่าน Statement
        $stmt->execute();
    
        // ส่งค่ากลับผลลัพธ์จากการใช้งานคำสั่ง SQL
        return $stmt;
    }
    
}
