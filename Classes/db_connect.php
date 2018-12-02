<?php
/**
 * Created by PhpStorm.
 * User: Sari
 * Date: 11/27/2018
 * Time: 8:24 PM
 */

class db_connect
{

    var $servername = "localhost";
    var $username = "root";
    var $password = "reed2020";


    public function doQuery($qry){
        $mysqli = new mysqli($this->servername, $this->username, $this->password, "stock_site");
        $result = $mysqli->query($qry);
        $mysqli->close();
        return $result;
    }

    public function doNonQuery($qry){
        try{
            $mysqli = new mysqli($this->servername, $this->username, $this->password, "stock_site");
            $mysqli->query($qry);
            $mysqli->close();
        }catch (Exception $ex){
            echo "Error: "+$ex;
        }
    }

}