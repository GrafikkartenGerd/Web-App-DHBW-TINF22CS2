<?php

include "BaseController.php";
include "../Database.php";

class AuthController extends BaseController
{
    public $db = null;
 
    public function __construct()
    {
        try {
            $this->db = new Database();
            
        } catch (Exception $e) {
            throw new Exception($e->getMessage());   
        }           
    }

    public function login($username, $password)
    {
        $result = $this->db->select("SELECT password, token from users WHERE username=?", "s", [$username])->fetch_all(MYSQLI_ASSOC);

        if(count($result) == 0)
            $this->fail(401);

        $hashedPassword = $result[0]["password"];
        if(!password_verify($password, $hashedPassword)) $this->fail(401);

        return $result[0]["token"];
        
        return $uid;
    }

    public function register($username, $password, $name, $surname, $birthday, $gender, $matriculation_number, $faculty, $degree, $course){

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $authToken = bin2hex(random_bytes(32));

        return $this->db->exec("INSERT INTO users (username, name, surname, password, birthday, gender, matriculation_number, faculty, degree, course, token) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);" , "ssssssissss", [$username, $name, $surname, $hashedPassword, $birthday->format("Y-m-d"), $gender, $matriculation_number, $faculty, $degree, $course, $authToken]);
    }
}
?>