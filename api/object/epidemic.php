<?php
class  Epidemic
{

    public function __construct($db)
    {
        $this->conn = $db;
    }
    private $conn;
    private $table_name = "epidemic";


    public $date;
    public $poid;
    public $confirmed;
    public $deaths;
    public $recovered;
    public $active;

    public function getAllDate()
    {
        $query = "SELECT date FROM " . $this->table_name . ' GROUP BY date order by date DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}