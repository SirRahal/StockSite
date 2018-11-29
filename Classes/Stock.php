<?php
/**
 * Created by PhpStorm.
 * User: Sari
 * Date: 11/25/2018
 * Time: 5:31 PM
 */

include_once ('db_connect.php');

class Stock
{

    var $Name;
    var $Symbol;
    var $Price;
    var $EXDate;
    var $Volume;
	var $PercentChange;
	var $DividendAmount;
	var $DividendDate;

	/*
	 * This is the main, when this
	 * */
    function __construct($symbol){
        $this->Symbol = $symbol;

        $this->setDataFromAlphaVantage();
        $this->Name = $this->getName();

        $this->DividendAmount = $this->getDividendAmount();
        $this->DividendDate = $this->getDividendDate();

    }

    /*
     * Sets the price, volume, change percentage
     * */
    function setDataFromAlphaVantage(){
        stream_context_set_default([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ]
        ]);

        $url = 'https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol='.$this->Symbol.'&apikey=2FLNEONK7AMR8Y79'; // path to your JSON file
        $data = file_get_contents($url); // put the contents of the file into a variable
        $stockData = json_decode($data); // decode the JSON feed

        foreach($stockData as $companyinfo) {
            $this->Price = $companyinfo->{'05. price'};
            $this->Volume = $companyinfo->{'06. volume'};
            $this->PercentChange = $companyinfo->{'10. change percent'};
        }
    }

    /*
     * Grabs name from the database
     * */
    function getName(){
        $results ="";
        $conn = new db_connect();
        $qry = $conn->doQuery("SELECT `name` FROM stock_site.stocks WHERE `symbol` = '".$this->Symbol."'");
        while ($row = $qry->fetch_row()) {
            $results = $row[0];
        }
        return $results;
    }

    /*
     * TODO: This needs to call an API and set the Dividend amount
     * */
    function getDividendAmount(){
        $result = "";
        return $result;
    }

    /*
     * TODO: This needs to call an API and set the Dividend date
     * */
    function getDividendDate(){
        $result = "";
        return $result;
    }
}
