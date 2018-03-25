<?php

class Database {

    const HOST = 'mysqlstudenti.litv.sssvt.cz';
    const USER = 'hellmannlukas';
    const PASSWORD = '123456a+';
    const DBNAME = '4b_hellmannlukas_db2';

    /*const HOST = 'localhost';
    const USER = 'root';
    const PASSWORD = '';
    const DBNAME = 'news';*/

    private $conn;

    function __construct() {
        try {
            $this->conn = new PDO("mysql:host=" . self::HOST . ";dbname=" . self::DBNAME, self::USER, self::PASSWORD);
            $this->conn->query('SET NAMES utf8');
        } catch (Exception $e) {
            die('Chyba připojení k databázi');
        }
    }
    
    function selectAll($query, $params = []) {
        return $this->execute($query, $params)->fetchAll();
    }
    
    function selectOne($query, $params = []) {
        return $this->execute($query, $params)->fetch();
    }
    
    function insert($query, $data) {
       $this->execute($query, $data);
        
        return $this->conn->lastInsertId();
    }
    
    function update($query, $data) {
       $stmt = $this->execute($query, $data);
       
       return $stmt->rowCount();
    }

    function remove($query, $data) {
        $stmt = $this->execute($query, $data);

        return;
    }
    
    private function execute($query, $data = []) {
        $stmt = $this->conn->prepare($query);
        $result = $stmt->execute($data);
        if (!$result) {
            var_dump($stmt->errorInfo());
            die();
        }
        
        return $stmt;
    }

}
