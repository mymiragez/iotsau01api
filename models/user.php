<?php
//ใช้ทำงานกับข้อมูล กับตาราง(Table):user_tb ในDatabase: iotsau_01_db
//มี Insert ใช้ POST , Update ใช้ PULL, delete ใช้ DELETE, select (ดึงข้อมูล) ใช้ GET 
class User
{
    //ตัวแปรที่ใช้สำหรับการติดต่อกับ DB เพื่อมาใช้การทำงานกับ Table ใน DB******
    private $connectDB;
    //สร้างตัวแปรที่ map กับ column ใน Table 
    public $user_id;
    public $user_fullname;
    public $user_name;
    public $user_password;
    public $user_age;

    public $message; //ตัวแปรสารพัดประโยชน์ ****

    //สร้าง Constructor เพื่อรับค่ามากำหนดให้กับตัวแปรที่ใช้สำหรับการติดต่อกับ DB*****
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


    public function checkLoginUser()
    {
        $strSQL = "SELECT * FROM user_tb WHERE user_name = :user_name and user_password = :user_password";

        $stmt = $this->connectDB->prepare($strSQL);


        //ถ้ามี parameter ต้องมีส่วนนี้เสมอ {{{{
        //เราเอาค่า user กับ password มากำหนดกับ parameter :user_name และ :user_password เลยไม่สามารถ execute ได้ทันที
        //ตรวจสอบค่าที่ส่งมาจาก Client ก่อนเพื่อกำหนดให้กับ parameter ของ  SQL
        $this->user_name = htmlspecialchars(strip_tags($this->user_name));
        $this->user_password = htmlspecialchars(strip_tags($this->user_password));

        //กำหนดค่าที่ส่งมาจาก Client ให้กับ Parameter ของ SQL
        $stmt->bindParam(":user_name", $this->user_name);
        $stmt->bindParam(":user_password", $this->user_password);
        //}}}}

        $stmt->execute();

        return $stmt;
    }
    public function inserUesr()
    {
        $strSQL = "INSERT INTO user_tb (user_fullname, user_name, user_password, user_age) VALUES (:user_fullname, :user_name, :user_password, :user_age)";

        $stmt = $this->connectDB->prepare($strSQL);

        //ตรวจสอบค่าที่ส่งมาจาก Client ก่อนเพื่อกำหนดให้กับ parameter ของ  SQL
        $this->user_fullname = htmlspecialchars(strip_tags($this->user_fullname));
        $this->user_name = htmlspecialchars(strip_tags($this->user_name));
        $this->user_password = htmlspecialchars(strip_tags($this->user_password));
        $this->user_age = intval(htmlspecialchars(strip_tags($this->user_age))); //อายุไม่ใช่ str แปลงเป็น int

        //กำหนดค่าที่ส่งมาจาก Client ให้กับ Parameter ของ SQL
        $stmt->bindParam(":user_fullname", $this->user_fullname);
        $stmt->bindParam(":user_name", $this->user_name);
        $stmt->bindParam(":user_password", $this->user_password);
        $stmt->bindParam(":user_age", $this->user_age);

        //สั่ง SQL ให้ทำงานผ่าน Statement
        if ($stmt->execute()) {
            //insert สำเร็จ
            return true;
        } else {
            //insert ไม่สำเร็จ
            return false;
        }
    }
    public function updateUser()
    {
        $strSQL = "UPDATE user_tb SET user_fullname = :user_fullname, user_name = :user_name, user_password = :user_password, user_age = :user_age WHERE user_id = :user_id";

        $stmt = $this->connectDB->prepare($strSQL);

        //ตรวจสอบค่าที่ส่งมาจาก Client ก่อนเพื่อกำหนดให้กับ parameter ของ  SQL
        $this->user_id = intval(htmlspecialchars(strip_tags($this->user_id)));
        $this->user_fullname = htmlspecialchars(strip_tags($this->user_fullname));
        $this->user_name = htmlspecialchars(strip_tags($this->user_name));
        $this->user_password = htmlspecialchars(strip_tags($this->user_password));
        $this->user_age = intval(htmlspecialchars(strip_tags($this->user_age))); //อายุไม่ใช่ str แปลงเป็น int

        //กำหนดค่าที่ส่งมาจาก Client ให้กับ Parameter ของ SQL
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":user_fullname", $this->user_fullname);
        $stmt->bindParam(":user_name", $this->user_name);
        $stmt->bindParam(":user_password", $this->user_password);
        $stmt->bindParam(":user_age", $this->user_age);

        //สั่ง SQL ให้ทำงานผ่าน Statement
        if ($stmt->execute()) {
            //Update สำเร็จ
            return true;
        } else {
            //Update ไม่สำเร็จ
            return false;
        }
    }
    public function deleteUser()
    {
        $strSQL = "DELETE FROM user_tb WHERE user_id = :user_id";

        $stmt = $this->connectDB->prepare($strSQL);

        //ตรวจสอบค่าที่ส่งมาจาก Client ก่อนเพื่อกำหนดให้กับ parameter ของ  SQL
        $this->user_id = intval(htmlspecialchars(strip_tags($this->user_id)));

        //กำหนดค่าที่ส่งมาจาก Client ให้กับ Parameter ของ SQL
        $stmt->bindParam(":user_id", $this->user_id);

        //สั่ง SQL ให้ทำงานผ่าน Statement
        if ($stmt->execute()) {
            //delete สำเร็จ
            return true;
        } else {
            //delete ไม่สำเร็จ
            return false;
        }
    }
}
