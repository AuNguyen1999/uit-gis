<?php
class Polygon
{
    private $conn;
    private $table_name = "polygon";

    public $id;
    public $name;
    public $area;
    public $region;
    public $points = [];
    public $confirmed;
    public $deaths;
    public $recovered;
    public $active;
    public $date;
    public $population;
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function readFoDate($date = null)
    {
        $query = "SELECT p.name as name, p.population as population , p.id as id, p.area as area, r.name as region, e.confirmed, e.deaths, e.recovered, e.active, e.date FROM " . $this->table_name . " p, region r, epidemic e  WHERE p.rid=r.id and e.poid=p.id and e.date='" . $date . "'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function read()
    {
        $query = "SELECT p.name as name, p.population as population , p.id as id, p.area as area, r.name as region FROM " . $this->table_name . " p, region r  WHERE p.rid=r.id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readFoRid($rid = "")
    {
        $query = "SELECT p.name as name, p.population as population , p.id as id FROM " . $this->table_name . " p WHERE p.rid='" . $rid . "'";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}