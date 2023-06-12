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
        $result = $this->db->select("SELECT id, username, name, surname, course FROM users WHERE username LIKE ? OR name LIKE ? OR surname LIKE ? or course LIKE ?;", "ssss", [$query, $query, $query, $query]);

        if($result == false)
            return null;
            
        $result = $result->fetch_all(MYSQLI_ASSOC);

        return $result;
    }

    public function getUserById($uid, $minimal = false){

        $cmd = "SELECT id, username, name, surname, birthday, gender, faculty, degree, course, profile_picture, bio, stuv FROM users WHERE id=?;";
        if($minimal)
            $cmd = "SELECT id, username, name, surname, profile_picture, course, birthday, bio FROM users WHERE id=?;";

        $result = $this->db->select($cmd, "i", [$uid]);

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
        $result = $this->db->select("SELECT id, username, name, surname, birthday, gender, faculty, degree, course, stuv FROM users WHERE username=?;", "s", [$username]);

        if($result == false)
            return null;
            
        $result = $result->fetch_all(MYSQLI_ASSOC);

        if(count($result) == 0)
            return null;
            
        return $result[0];
    }

    public function updateProfileInfo($uid, $name, $surname, $bio){
        $result = $this->db->exec("UPDATE users SET name=?, surname=?, bio=? WHERE id=?", "sssi", [$name, $surname, $bio, $uid]);
        return $result;
    }

    public function changeProfilePicture($uid){
        if(!isset($_FILES['profile_picture']))
            return "Invalid profile picture.";

        $file = $_FILES["profile_picture"]; 

        if(!@is_array(getimagesize($file['tmp_name'])))
            return "Invalid image format.";
        
        if(round(filesize($file['tmp_name']) / 1024 / 1024, 1) > 2)
            return "Profile picture is too large (Max 2MB)";
        
        $uploadDir =  "../pfp";
        $fileName = "/".$uid.".webp";
        $uploadPath = $uploadDir.$fileName;
        if(!move_uploaded_file($file['tmp_name'], $uploadPath))
            return "Internal server error.";

        $result = $this->db->exec("UPDATE users SET profile_picture=? WHERE id=?", "si", [$uploadPath, $uid]);

        return $result;
    }
}

?>