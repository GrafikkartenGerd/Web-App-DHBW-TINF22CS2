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
 
    public function getEventCount(){
        $result = $this->db->select("SELECT id from events", "", []);

        if($result == false)
            return 0;
            
        $result = $result->fetch_all(MYSQLI_ASSOC);

        return count($result);
    }

    public function getEventsforUser($user, $filter_level)
    {
        if($filter_level != "all"){
            $filterParam = $user[$filter_level];
            $events = $this->db->select("SELECT id, name, date, place, host, content, faculty, degree, course, stuv FROM events WHERE ".$filter_level."=? AND date > NOW() ORDER BY date ASC LIMIT 100;", "s", [$filterParam]);
        }else{
            $events = $this->db->select("SELECT id, name, date, place, host, content, faculty, degree, course, stuv FROM events WHERE date > NOW() ORDER BY date ASC LIMIT 100;", "", []);
        }
        
        if($events == false)
            return null;

        $events = $events->fetch_all(MYSQLI_ASSOC);

        if (count($events) == 0) 
            return null;

        return $events;
    }

    public function createEvent($name, $date, $place, $content, $faculty, $degree, $course, $stuv, $host){

        return $this->db->exec("INSERT INTO events (name, date, place, content, faculty, degree, course, stuv, host) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);" , "sssssssii", [$name, $date, $place, $content, $faculty, $degree, $course, $stuv, $host]);
    }
}