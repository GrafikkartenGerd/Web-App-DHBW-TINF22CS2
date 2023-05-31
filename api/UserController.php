<?php

require_once "BaseController.php";
require_once "../Database.php";

class UserController extends BaseController
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

    public function searchUsers($query){

        $query = '%'.$query.'%';
        $result = $this->db->select("SELECT username, name, surname, course FROM users WHERE username LIKE ? or course LIKE ?;", "ss", [$query, $query]);

        if($result == false)
            return null;
            
        $result = $result->fetch_all(MYSQLI_ASSOC);

        return $result;
    }

    public function getUserById($uid){

        $result = $this->db->select("SELECT id, username, name, surname, birthday, gender, faculty, degree, course FROM users WHERE id=?;", "i", [$uid]);

        if($result == false)
            return null;
            
        $result = $result->fetch_all(MYSQLI_ASSOC);

        if(count($result) == 0)
            return null;
            
        return $result[0];
    }

    public function getUserCount(){
        $result = $this->db->select("SELECT id from users", "", []);

        if($result == false)
            return 0;
            
        $result = $result->fetch_all(MYSQLI_ASSOC);

        return count($result);
    }

    public function deleteUser($uid){
        $result = $this->db->exec("DELETE from users WHERE id=?", "i", [$uid]);
        return $result;
    }

    public function setUserPassword($uid, $password){

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $result = $this->db->exec("UPDATE users SET password=? WHERE id=?", "si", [$hashedPassword, $uid]);
        return $result;
    }

    public function getUserByUsername($username)
    {
        $result = $this->db->select("SELECT id, username, name, surname, birthday, gender, faculty, degree, course FROM users WHERE username=?;", "s", [$username]);

        if($result == false)
            return null;
            
        $result = $result->fetch_all(MYSQLI_ASSOC);

        if(count($result) == 0)
            return null;
            
        return $result[0];
    }
}

?>