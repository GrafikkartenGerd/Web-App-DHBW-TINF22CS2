<?php

include "BaseController.php";
include "../Database.php";

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
        $result = $this->db->select("SELECT username, name, surname, birthday, gender, faculty, degree, course FROM users WHERE token=?;", "s", [$authToken])->fetch_all(MYSQLI_ASSOC);

        if(count($result) == 0)
            return ['status' => false];
            
        return ['status' => true, 'data' => $result[0]];
    }
}

?>