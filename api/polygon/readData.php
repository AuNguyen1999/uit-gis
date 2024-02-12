<?php

include_once "../object/polygon.php";
include_once "../config/DBConfig.php";
include_once "../point/index.php";

function getForRid($rid)
{
    $database = new Database();
    $db = $database->connect();
    $polygon = new Polygon($db);
    $stmt = $polygon->readFoRid($rid);
    $num = $stmt->rowCount();

    if ($num > 0) {
        $polygon_arr = array();
        // $polygon_arr['data'] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $polygon_item = array(

                getPoP($db, $id)
            );
            array_push($polygon_arr, $polygon_item);
        }

        return $polygon_arr;
    } else {

        return [];
    }
}