<?php

require_once "BaseController.php";
require_once "Database.php";

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

    public function searchEvents($query){
        $query = '%'.$query.'%';
        $result = $this->db->select("SELECT id, name, date, place, host, content, faculty, degree, course, stuv, accepted, declined FROM events WHERE name LIKE ? OR place LIKE ? OR content LIKE ? ORDER BY date ASC;", "sss", [$query, $query, $query]);

        if($result == false)
            return null;
            
        $result = $result->fetch_all(MYSQLI_ASSOC);

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

    private function getFilterSuffix($user, $filter_level){
        switch($filter_level){
            case "next":
            case "upcoming":
                return " WHERE date > NOW() ORDER BY date ASC";
            case "today":
                $today = date('Y-m-d');
                return " WHERE DATE_FORMAT(date, '%Y-%m-%d') = '$today' ORDER BY date ASC";
            case "past":
                return " WHERE date < NOW() ORDER BY date DESC LIMIT 100";
                break;
            case "declined":
            case "joined":
                return " ORDER BY date ASC";
            default:
                return null;
        }
    }

    public function getEventsFiltered($user, $filter_level)
    {
        $suffix = $this->getFilterSuffix($user, $filter_level);
        if($suffix == null) return null;

        $events = $this->db->select("SELECT id, name, date, place, host, content, faculty, degree, course, stuv, accepted, declined FROM events ".$suffix, "", []);
        
        if($events == false)
            return null;

        $events = $events->fetch_all(MYSQLI_ASSOC);
        
        
        if($filter_level == "next"){
            foreach($events as $event){
                if($this->userEventAcceptanceStatus($event, $user["id"]) == 0)
                    return array($event);
            }

            return array();
        }

        if($filter_level == "declined" || $filter_level == "joined"){
            $filteredEvents = [];
            foreach($events as $event){
                $accStatus = $this->userEventAcceptanceStatus($event, $user["id"]);

                // check if the acceptance status matched the filter level
                if((($filter_level == "declined" && $accStatus == 2) || 
                ($filter_level == "joined" && $accStatus == 1))
                && $event["host"] != $user["id"])   // exclude own events
                    $filteredEvents[] = $event;
            }

            return $filteredEvents;
        }

        return $events;
    }

    public function getEventsByUser($uid, $limit = true){
        $limitCmd = $limit ? " LIMIT 100" : "";
        $events = $this->db->select("SELECT id, name, date, place, host, content, faculty, degree, course, stuv, accepted, declined FROM events WHERE host=? ORDER BY date".$limitCmd, "i", [$uid]);
    
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