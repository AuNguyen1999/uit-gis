<?php
class Point
{
    private $conn;
    private $table_name = "point";

    public $long;
    public $lat;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read($poid)
    {
        $query = "SELECT p.long, p.lat FROM " . $this->table_name . " p, pointpolygon WHERE pointpolygon.poid='" . $poid . "'" . "AND pointpolygon.pid=p.id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}