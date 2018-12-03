<?php
/**
 * Created by PhpStorm.
 * User: Sari
 * Date: 11/25/2018
 * Time: 6:39 PM
 */

include_once ("Stock.php");
include_once("db_connect.php");

class User
{
    var $Name;
    var $UserID;
    var $FavoritsList = array();

    function __construct($userID){
    	$this->UserID = $userID;
    	$this->setName();
    	$this->setFavorites();	
        
    }

    function setFavorites(){
    	$con = new db_connect();
		$qry = "SELECT symbol FROM favorites WHERE `user` = ". $this->UserID;
       
		$results = $con->doQuery($qry);

		while ($row = $results->fetch_row()) {
	 		array_push($this->FavoritsList, new Stock($row[0]));
	 	}
    }

    function setName(){
    	$con = new db_connect();
    	$qry = "SELECT name FROM users WHERE `ID` = ". $this->UserID;
       
		$results = $con->doQuery($qry);

		while ($row = $results->fetch_row()) {
	 		$this->Name = $row[0];
	 	}
    }

}