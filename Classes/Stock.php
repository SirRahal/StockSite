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
    var $DividendPercent;

	/*
	 * This is the main, when this
	 * */
    function __construct($symbol){
        $this->Symbol = $symbol;

        $this->setDataFromAlphaVantage();
        $this->Name = $this->getName();
        $this->setAPIIextrading();
        $this->DividendPercent = $this->getDividendPercent();
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
     * Sets the Dividend =
     * */
    function setAPIIextrading(){
        stream_context_set_default([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ]
        ]);

        $url = 'https://api.iextrading.com/1.0/stock/'. $this->Symbol .'/dividends/1y'; // path to your JSON file
        $data = file_get_contents($url); // put the contents of the file into a variable
        $stockData = json_decode($data); // decode the JSON feed

        if($stockData[0] != null){ 
            $this->EXDate = $stockData[0]->{'exDate'};
            $this->DividendAmount = $stockData[0]->{'amount'};
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

    function getDividendPercent(){
        if($this->Price != 0 && $this->DividendAmount != 0){
            return  $this->DividendAmount/$this->Price;
        }else{
            return 0;
        }
    }
}
