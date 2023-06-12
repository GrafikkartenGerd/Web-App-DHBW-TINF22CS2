<?php

require_once "BaseController.php";
require_once "../Database.php";

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
        $result = $this->db->select("SELECT id, username, name, password, surname, birthday, gender, faculty, degree, course, profile_picture, is_admin, stuv from users WHERE username=?", "s", [$username]);

        if($result == false)
            return null;

        $result = $result->fetch_all(MYSQLI_ASSOC);


        if(count($result) == 0)
            return false;

        $hashedPassword = $result[0]["password"];
        if(!password_verify($password, $hashedPassword)) return false;

        return $result[0];
    }

    public function refreshUser($username){
        $result = $this->db->select("SELECT id, username, name, password, surname, birthday, gender, faculty, degree, course, profile_picture, is_admin, stuv from users WHERE username=?", "s", [$username]);

        if($result == false)
            return null;

        $result = $result->fetch_all(MYSQLI_ASSOC);


        if(count($result) == 0)
            return false;

        return $result[0];
    }

    function getTokenByUsername($username, $expired) {
	    $cmd = "SELECT * from auth_tokens where username=? and is_expired=?";
	    $result = $this->db->select($cmd, 'si', [$username, $expired]);
        
        if($result == false)
            return null;

        $result = $result->fetch_all(MYSQLI_ASSOC);


        if(count($result) == 0)
            return false;

        return $result;
    }
    
    function markTokenAsExpired($tokenId) {
        $cmd = "UPDATE auth_tokens SET is_expired=? WHERE id=?";
        $result = $this->db->exec($cmd, 'ii', [1, $tokenId]);
        return $result;
    }
    
    function insertToken($username, $auth_token_hash, $auth_id_hash, $expiry_date) {
        $cmd = "INSERT INTO auth_tokens (username, password_hash, selector_hash, expiry_date) values (?, ?, ?, ?)";
        $result = $this->db->exec($cmd, 'ssss', [$username, $auth_token_hash, $auth_id_hash, $expiry_date]);
        return $result;
    }

    public function register($username, $password, $name, $surname, $birthday, $gender, $matriculation_number, $faculty, $degree, $course){

        $result = $this->db->select("SELECT password, token from users WHERE username=?", "s", [$username]);

        if($result == false)
            return null;

        $result = $result->fetch_all(MYSQLI_ASSOC);

        if(count($result) != 0)
            return "Username unavailable.";

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $authToken = bin2hex(random_bytes(32));

        return $this->db->exec("INSERT INTO users (username, name, surname, password, birthday, gender, matriculation_number, faculty, degree, course, token, profile_picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);" , "ssssssisssss", [$username, $name, $surname, $hashedPassword, $birthday->format("Y-m-d"), $gender, $matriculation_number, $faculty, $degree, $course, $authToken, "/pfp/default.jpg"]);
    }
}
?>