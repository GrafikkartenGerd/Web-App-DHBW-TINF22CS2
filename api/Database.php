<?php

include_once "config.php";

class Database
{
    protected $connection = null;
 
    public function __construct()
    {
        try {
            $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
         
            if ( mysqli_connect_errno()) {
                throw new Exception("Could not connect to database.");   
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());   
        }           
    }
 
    public function select($query = "" , $type, $params = [])
    {
        try {
            $stmt = $this->executeStatement( $query, $type, $params );
            $result = $stmt->get_result();          
            $stmt->close();
            
            return $result;
        } catch(Exception $e) {
            
            return false;
        }
        return false;
    }

    public function exec($query = "", $type = "", $params = []){
        try {
            $stmt = $this->connection->prepare( $query );

            if($stmt === false) {
                throw New Exception("Unable to do prepared statement: " . $query);
            }
 
            if( $params ) {
                $stmt->bind_param($type, ...$params);
            }
 
            $result = $stmt->execute();
           
            $stmt->close();
            return $result;

        } catch(Exception $e) {
            return false;
           
        }   
    }
 
    private function executeStatement($query = "", $type = "", $params = [])
    {
        try {
            $stmt = $this->connection->prepare($query);

        if ($stmt === false) {
            throw new Exception("Unable to do prepared statement: " . $query);
        }

        if ($params) {
            $stmt->bind_param($type, ...$params);
        }

        $stmt->execute();
    
        return $stmt;

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
?>