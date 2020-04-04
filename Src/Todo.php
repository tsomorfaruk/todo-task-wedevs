<?php

namespace App;
use PDO;

class Todo
{
    private $host = "localhost";
    private $user = "root";
    private $db = "db_todo";
    private $pass = "";
    private $conn;

    public function __construct()
    {
        $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db, $this->user, $this->pass);
    }

    public function showData($table)
    {
        $data = array();
        $sql = "SELECT * FROM $table";
        $q = $this->conn->query($sql) or die("failed!");
        while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $r;
        }
        return $data;
    }

    public function getByStatus($status, $table)
    {
        $data = array();
        $sql = "SELECT * FROM $table WHERE status = :status";
        $q = $this->conn->prepare($sql);
        $q->execute(array(':status' => $status));
        while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $r;
        }
        return $data;
    }

    public function insertData($todo, $table)
    {
        $sql = "INSERT INTO $table SET todos=:todo";
        $q = $this->conn->prepare($sql);
        $q->execute(array(':todo' => $todo));
        return true;
    }

    public function rowCount($table){
        $sql = "SELECT count(*) FROM $table WHERE status = 0";
        $result = $this->conn->prepare($sql);
        $result->execute();
        return $result->fetchColumn();
    }

    public function getById($id, $table)
    {
        $sql = "SELECT * FROM $table WHERE id = :id";
        $q = $this->conn->prepare($sql);
        $q->execute(array(':id' => $id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function completeData($id, $table)
    {
        $sql = "UPDATE $table SET status=:status WHERE id=:id";
        $q = $this->conn->prepare($sql);
        $q->execute(array(':id' => $id, ':status' => 1));
        return true;
    }
    public function updateData($id, $data, $table)
    {
        $sql = "UPDATE $table SET todos=:todos WHERE id=:id";
        $q = $this->conn->prepare($sql);
        $q->execute(array(':id' => $id, ':todos' => $data));
        return true;
    }

    public function clearCompleteData($table)
    {
        $sql = "DELETE FROM $table WHERE status=:status";
        $q = $this->conn->prepare($sql);
        $q->execute(array(':status' => 1));
        return true;
    }
}


