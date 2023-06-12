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

    public function deleteEvent($eid){
        $result = $this->db->exec("DELETE from events WHERE id=?", "i", [$eid]);
        return $result;   
    }

    public function getEventById($eid){
        $result = $this->db->select("SELECT id, name, date, place, host, content, faculty, degree, course, stuv, accepted, declined FROM events WHERE id=?;", "i", [$eid]);

        if($result == false)
            return null;
            
        $result = $result->fetch_all(MYSQLI_ASSOC);

        if(count($result) == 0)
            return null;
            
        return $result[0];
    }

    public function getEventsforUser($user, $filter_level)
    {
        if($filter_level != "all"){
            $filterParam = $user[$filter_level];
            $events = $this->db->select("SELECT id, name, date, place, host, content, faculty, degree, course, stuv, accepted, declined FROM events WHERE ".$filter_level."=? AND date > NOW() ORDER BY date ASC LIMIT 100;", "s", [$filterParam]);
        }else{
            $events = $this->db->select("SELECT id, name, date, place, host, content, faculty, degree, course, stuv, accepted, declined FROM events WHERE date > NOW() ORDER BY date ASC LIMIT 100;", "", []);
        }
        
        if($events == false)
            return null;

        $events = $events->fetch_all(MYSQLI_ASSOC);
        
        return $events;
    }

    public function userEventAcceptanceStatus($event, $uid){

        if($event["host"] == $uid) return 1;

        $acceptedUsers = explode(',', $event['accepted']);
        $declinedUsers = explode(',', $event['declined']);
        
        if (in_array($uid, $acceptedUsers)) {
            return 1;
        } elseif (in_array($uid, $declinedUsers)) {
            return 2;
        } else {
            return 0;
        }

    }

    public function getParticipants($event){

        $acceptedUsers = explode(',', $event['accepted']);
        return $acceptedUsers;
    }

    public function userAcceptEvent($event, $uid){

        $acceptedUsers = explode(',', $event['accepted']);
        $declinedUsers = explode(',', $event['declined']);
        
        if (in_array($uid, $declinedUsers)) {
            $index = array_search($uid, $declinedUsers);
            unset($declinedUsers[$index]);
            $declined = implode(',', $declinedUsers);
        }
    
        if (!in_array($uid, $acceptedUsers)) {
            $acceptedUsers[] = $uid;
            $accepted = implode(',', $acceptedUsers);
        }

        if(!isset($declined))
            $declined = $event['declined'];

        if(!isset($accepted))
            $accepted = $event['accepted'];

        return $this->db->exec("UPDATE events SET accepted=?, declined=? WHERE id=?", "ssi", [$accepted, $declined, $event["id"]]);
    }

    public function userDeclineEvent($event, $uid){
        
        $acceptedUsers = explode(',', $event['accepted']);
        $declinedUsers = explode(',', $event['declined']);
        
        if (in_array($uid, $acceptedUsers)) {
            $index = array_search($uid, $acceptedUsers);
            unset($acceptedUsers[$index]);
            $accepted = implode(',', $acceptedUsers);
        }
        
        if (!in_array($uid, $declinedUsers)) {
            $declinedUsers[] = $uid;
            $declined = implode(',', $declinedUsers);
        }

        if(!isset($accepted))
            $accepted = $event['accepted'];

        if(!isset($declined))
            $declined = $event['declined'];
        
        return $this->db->exec("UPDATE events SET accepted=?, declined=? WHERE id=?", "ssi", [$accepted, $declined, $event["id"]]);

    }

    public function createEvent($name, $date, $place, $content, $faculty, $degree, $course, $stuv, $host){

        $status = $this->db->exec("INSERT INTO events (name, date, place, content, faculty, degree, course, stuv, host) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);" , "sssssssii", [$name, $date->format('Y-m-d H:i:s'), $place, $content, $faculty, $degree, $course, $stuv, $host]);
        if($status == false) return false;

        return $this->db->insertId();
    }
}