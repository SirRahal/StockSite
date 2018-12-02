<?php

include_once ('Classes/Stock.php');

$stock = new Stock('DIS');

echo "Name: ". $stock->Name;
echo "<br/>";
echo "Symbol: ". $stock->Symbol;
echo "<br/>";
echo "Price: ". number_format($stock->Price, 2);
echo "<br/>";
echo "Volume: ". number_format($stock->Volume);
echo "<br/>";
echo "Percent Changed: ". $stock->PercentChange;
echo "<br/>";
echo "EXDate: ". $stock->EXDate;
