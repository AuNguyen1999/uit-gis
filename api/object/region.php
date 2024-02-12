<?php
class Region
{
    private $conn;
    private $table_name = "region";

    public $id;
    public $name;
    public $area;
    public $population;
    public $confirmed;
    public $recovered;
    public $deaths;
    public $active;
    public $date;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = "SELECT r.id as id, r.name as name, SUM(p.area) as area, SUM(p.population) as population FROM region r, polygon p WHERE r.id=p.rid GROUP BY r.name";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readFoDateRegion($date)
    {
        $query = "SELECT r.id as id, r.name as name, SUM(p.area) as area, SUM(p.population)  as population, SUM(e.confirmed) as confirmed, SUM(e.recovered) as recovered,SUM(e.deaths) as deaths, SUM(e.active) as active  FROM " . $this->table_name . " r, polygon p, epidemic e WHERE r.id=p.rid AND  p.id = e.poid and e.date='" . $date . "' GROUP BY r.name";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}