<?php

require_once "BaseController.php";
require_once "../Database.php";

class EventController extends BaseController
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
 
    public function getEventsforUser($user, $filter_level)
    {
        
        if($filter_level != "all"){
            $filterParam = $user[$filter_level];
            $events = $this->db->select("SELECT name, date, place, content, faculty, degree, course, stuv FROM events WHERE ".$filter_level."=? AND date > NOW() ORDER BY date ASC;", "s", [$filterParam]);
        }else{
            $events = $this->db->select("SELECT name, date, place, content, faculty, degree, course, stuv FROM events WHERE date > NOW() ORDER BY date ASC;", "", []);
        }
        
        if($events == false)
            return null;

        $events = $events->fetch_all(MYSQLI_ASSOC);

        if (count($events) == 0) 
            return null;

        return $events;
    }
}