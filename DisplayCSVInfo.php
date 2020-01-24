<?php

require_once('Functions.php');
require_once('header.html');
require_once('DBConnect.php');

class DisplayCSVInfo
{
    public $tableName;

    function __construct($tableName)
    {
        $this->tableName = $tableName;
    }

    public function displayData()
    {
        $sku = "";
        $cost = 0.00;
        $price = 0.00;
        $qty = 0;
        $totalCost = 0.00;
        $totalPrice = 0.00;
        $avgCost = 0.00;
        $avgPrice = 0.00;
        $totalQty = 0.00;
        $profitMargin = 0;
        $avgProfitMargin = 0;
        $totalProfit = 0.00;
        $totalProfitUSD = 0.00;
        $totalProfitCAD = 0.00;
        $totalProfitUSDAccumulator = 0.00;
        $totalProfitCADAccumulator = 0.00;

        $counter = 0;

        $displayArray = [];

        $curConvert = new CurrencyConversion();
        $Functions = new Functions();

//        echo "<h1 style=\"text-align: center\">CRIMSON AGILITY</h1>";
        echo "<div id='logoDiv'><img id='logo' src='images/crimsonLogo.png'></div>";
        echo "<table border='1' style=\"width:100%\">
              <tr>
                <th>SKU</th>
                <th>COST</th>
                <th>PRICE</th>
                <th>QTY</th>
                <th>PROFIT</th>
                <th>TOTAL PROFIT (USD)</th>
                <th>TOTAL PROFIT (CAD)</th>
              </tr>";

       // get display array using DBConnect function getDBData
        $DBConnection = new DBConnect(
            "localhost",
            "admin",
            "R1HO8MIdHtAKTDbz",
            "csvReports" ,
            "$this->tableName");
        $displayArray = $DBConnection->getDBData();

        var_dump($displayArray);
        // Iterate over display table data and print table to screen
        while($row = $displayArray->fetch_array()) {

            // calculate profit margin and total profits
            $profitMargin = intval((($row->price - $row->cost) / $row->price) * 100);
            $totalProfitUSD = ($row->price - $row->cost) * $row->qty;
            $totalProfitUSD = number_format((float)$totalProfitUSD, 2, '.', '');

            //$totalProfitCAD = ($row->price - $row->cost) * $row->qty;

            // convert currency
            $curConvert->set_usd($totalProfitUSD);

            $temp = $curConvert->convert();

            $totalProfitCAD = number_format((float)$temp, 2, '.', '');

            $totalCost += $row->cost;
            $totalPrice += $row->price;
            $totalQty += $row->qty;

            echo "  <tr>
                    <td>$row->sku</td>
                    <td>$$row->cost</td>
                    <td>$$row->price</td>";
            if ($row->qty > 0) {
                echo "<td style=' color: green;'> $row->qty</td >";

            } else {
                echo "<td style=' color: red;'> $row->qty</td >";
            }

            if ($profitMargin > 0) {
                echo "<td style=' color: green;'> $profitMargin%</td >";
            } else {
                echo "<td style=' color: red;'> $profitMargin% </td >";
            }

            if ($totalProfitUSD > 0) {
                echo "<td style=' color: green;'> $$totalProfitUSD </td >";
            } else {
                echo "<td style=' color: red;'> $$totalProfitUSD </td >";
            }

            if ($totalProfitCAD > 0) {
                echo "<td style=' color: green;'>  $$totalProfitCAD  </td >";
            } else {
                echo "<td style=' color: red;'> $$totalProfitCAD  </td ></tr>";
            }

            $totalProfitUSDAccumulator += $row->totalProfitUSD;
            $totalProfitCADAccumulator += $row->totalProfitCAD;
            $counter++;
        }


        if(sizeof($displayArray) > 0) {
            // calculate averages
            $avgCost = $totalCost / $counter;
            $avgPrice = $totalPrice / $counter;
            $totalProfitUSDAccumulator = number_format((float)$totalProfitUSDAccumulator, 2, '.', '');
            $totalProfitCADAccumulator = number_format((float)$totalProfitCADAccumulator, 2, '.', '');
            $avgCost = number_format((float)$avgCost, 2, '.', '');
            $avgPrice = number_format((float)$avgPrice, 2, '.', '');
        }
        else{
            $Functions->alert("No Information Uploaded");
        }

            echo "  <tr >
    
              <th ></th>
              <th >Avg Cost</th>
              <th >Avg Price</th>
              <th >Total Qty</th>
              <th >Avg Profit Margin</th>
              <th >Total Profit (USD)</th>  
              <th >Total Profit (CAD)</th>
              
    </tr>
    <tr>
                        <td></td>
                        <td>$$avgCost </td>
                        <td>$$avgPrice </td>
                        <td>$totalQty</td>
                        <td>$profitMargin%</td>
                        <td>$$totalProfitUSDAccumulator</td>
                        <td>$$totalProfitCADAccumulator</td>
                      </tr>";


            echo "</table>";
            echo "<a href='index.php'>Back</a><br/>";


    }
}