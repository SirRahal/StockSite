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
	var $Sector;
	var $Industry;
	var $UpdatedTimeStamp;

	/*
	 * This is the main, when this
	 * */
    function __construct($symbol){
        $this->Symbol = $symbol;
        $this->setStockDataFromDB();
        if( strtotime('-7 day') < $this->UpdatedTimeStamp){
            $this->setDataFromAlphaVantage();
            $this->DividendAmount = $this->getDividendAmount();
            $this->DividendDate = $this->getDividendDate();
            $this->UpdateRecordInDB();
        }
    }

    function UpdateRecordInDB(){
        $qry = "UPDATE stocks SET Price = ".$this->Price;

        if($this->EXDate != null && $this->EXDate != '0000-00-00'){
            $qry = $qry .",exDate = '". date("Y-m-d",strtotime($this->EXDate))."'";
        }

        if($this->DividendDate != null & $this->DividendDate != '0000-00-00'){
            $qry = $qry .",dividendDate = '". date("Y-m-d",strtotime($this->DividendDate)) ."'";
        }

        if($this->DividendAmount != null){
            $qry = $qry .",dividendAmount = ".$this->DividendAmount;
        }

        if($this->Volume != null){
            $qry = $qry .",volume = ". $this->Volume;
        }

        if($this->PercentChange != null){
            $qry = $qry .",percentChange = ".  preg_replace('/[^0-9,.\-]/', '', $this->PercentChange);
        }

        $qry = $qry .
            ",sector = '".$this->Sector."'"
            .",industry = '".$this->Industry."' WHERE symbol = '".$this->Symbol."'";

        $conn = new db_connect();
        $conn->doNonQuery($qry);
    }

    /*
     * Select the record from the database
     * */
    function setStockDataFromDB(){
        $conn = new db_connect();
        $qryString = "SELECT `name`,`sector`,`industry`,`price`,`exDate`,`volume`,`percentChange`, `dividendAmount`, `dividendDate`, `updatedTimeStamp` FROM stock_site.stocks WHERE `symbol` = '".$this->Symbol."'";
        $qry = $conn->doQuery($qryString);
        while ($row = $qry->fetch_row()) {
            $this->Name = $row[0];
            $this->Sector = $row[1];
            $this->Industry = $row[2];
            $this->Price = floatval($row[3]);
            $this->EXDate = $row[4];
            $this->Volume = $row[5];
            $this->PercentChange = $row[6];
            $this->DividendAmount = $row[7];
            $this->DividendDate = $row[8];
            $this->UpdatedTimeStamp =$row[9];
        }
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
            $this->Price = floatval ($companyinfo->{'05. price'});
            $this->Volume = floatval ($companyinfo->{'06. volume'});
            $this->PercentChange = $companyinfo->{'10. change percent'};
            $this->PercentChange = $this->PercentChange;
        }
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
