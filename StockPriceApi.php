<?php

include_once ('Classes/Stock.php');

$stock = new Stock('DIS');

echo $stock->Symbol .": ". $stock->Price;


