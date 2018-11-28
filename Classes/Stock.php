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

    function __construct($symbol){
        $this->Symbol = $symbol;

        stream_context_set_default([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ]
        ]);

        $url = 'https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol='.$symbol.'&apikey=2FLNEONK7AMR8Y79'; // path to your JSON file
        $data = file_get_contents($url); // put the contents of the file into a variable
        $stockData = json_decode($data); // decode the JSON feed

        foreach($stockData as $companyinfo) {
            $this->Price = $companyinfo->{'05. price'};
            $this->Volume = $companyinfo->{'06. volume'};
			$this->PercentChange = $companyinfo->{'10. change percent'};
        }
		
        $conn = new db_connect();

        $qry = $conn->doQuery("SELECT `name` FROM stock_site.stocks WHERE `symbol` = '".$this->Symbol."'");

        while ($row = $qry->fetch_row()) {
            $this->Name = $row[0];
        }


    }
}
