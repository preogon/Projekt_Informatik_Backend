<?php
namespace Helpers;

use PDO;
use Exception;
class SQLite {
    private PDO $PDO;

    /**
     * @param string $path path to database
     */
    public function __construct (string $path) {
        $this->connect($path);
    }

    private function connect (string $path) {
        $this->PDO = new PDO("sqlite:".$path);
        $this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->PDO->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_TO_STRING);
    }

    /**
     * Executes a SQL query and return the result as array
     * @param string $query query to be executed
     * @param array $params query parameters like array(":id"=>"1");
     * @return array Result of the query
     */
    public function execute (string $query, array $params = array()):array {
        try {
            $this->PDO->beginTransaction();
            $statement = $this->PDO->prepare($query);
            $statement->execute($params);
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            $this->PDO->commit();
            return $data;
        } catch (Exception $e){
            $this->PDO->rollBack();
            return array();
        } 
    }
} 