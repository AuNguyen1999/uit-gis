<?php

function getPoP($db, $poid)
{
    include_once "../object/point.php";

    $pop = new Point($db);
    $stmt = $pop->read($poid);
    $num = $stmt->rowCount();

    if ($num > 0) {
        $pop_arr = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $pop_item = array(
                (float)$long,
                (float) $lat
            );
            array_push($pop_arr, $pop_item);
        }
        return  $pop_arr;
    } else {
        return   $pop_item["points"] = [];
    }
}