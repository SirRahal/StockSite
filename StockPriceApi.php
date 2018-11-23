<?php
stream_context_set_default([
   'ssl' => [
       'verify_peer' => false, 
	   'verify_peer_name' => false,
	   ]
	]);
	
$url = 'https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol=DIS&apikey=2FLNEONK7AMR8Y79'; // path to your JSON file
$data = file_get_contents($url); // put the contents of the file into a variable
$stockdata = json_decode($data); // decode the JSON feed

foreach($stockdata as $companyinfo) {
echo $companyinfo->{'05. price'};
}
?>