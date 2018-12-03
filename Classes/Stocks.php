<?php
/**
 * Created by PhpStorm.
 * User: Sari
 * Date: 12/2/2018
 * Time: 1:51 PM
 */

include_once ('Stock.php');
include_once ('db_connect.php');

class Stocks
{
    var $Records = array();

    function getFirstStocks(){
        $qry = "SELECT `symbol` FROM stocks ORDER BY `name` LIMIT 5";
        //select all of  favorits limit 100

        $conn = new db_connect();
        $results = $conn->doQuery($qry);

        while ($row = $results->fetch_row()) {
            array_push($this->Records,new Stock($row[0]));
        }
        return $this->Records;
    }

}