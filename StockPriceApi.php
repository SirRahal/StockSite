<?php

include_once ('Classes/Stock.php');
include_once ('Classes/Stocks.php');

//$stock = new Stock('DIS');

$Stocks = new Stocks();
$list = $Stocks->getFirstStocks();

foreach ($list as $stock){
    echo "<br/>";
    echo "Name: ". $stock->Name;
    echo "<br/>";
    echo "Symbol: ". $stock->Symbol;
    echo "<br/>";
    echo "Price: ". number_format($stock->Price, 2);
    echo "<br/>";
    echo "EXDate: ". $stock->EXDate;
    echo "<br/>";
    echo "Dividend: ". $stock->DividendAmount;
    echo "<br/>";
    echo "Dividend %: ". number_format($stock->DividendPercentage, 4);
    echo "<br/>";
    echo "Volume: ". number_format($stock->Volume);
    echo "<br/>";
    echo "Percent Changed: ". $stock->PercentChange;
    echo "<br/>";
    echo "EXDate: ". $stock->EXDate;
}
