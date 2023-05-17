<?php

require_once "BaseController.php";
require_once "../Database.php";

class ProfileController extends BaseController
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

    public function getProfile($authToken)
    {
        $result = $this->db->select("SELECT username, name, surname, birthday, gender, faculty, degree, course FROM users WHERE token=?;", "s", [$authToken]);

        if($result == false)
            return null;
            
        $result = $result->fetch_all(MYSQLI_ASSOC);

        if(count($result) == 0)
            return null;
            
        return $result[0];
    }
}

?>