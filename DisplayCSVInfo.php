<?php

require_once('Functions.php');
require_once('header.html');

class DisplayCSVInfo
{
    public $key_value_array;

    function __construct($key_value_array)
    {
        $this->key_value_array = $key_value_array;
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

        // Select all data from csvReports Database using tableName

        // populate a 2d array with table info

        // Iterate over 2d table data and print table to screen
        

//        // loop over the column size of the inverted array
//        // this will give the size of the rows needed to display $this->key_value_array['sku']
//        for ($row = 0; $row < sizeOf($this->key_value_array['sku']); $row++) {
//            // assign values to variables
//            $sku = $this->key_value_array['sku'][$row];
//            $cost = $this->key_value_array['cost'][$row];
//            $price = $this->key_value_array['price'][$row];
//            $qty = $this->key_value_array['qty'][$row];
//
//            // calculate profit margin and total profits
//            $profitMargin = intval((($price - $cost) / $price) * 100);
//            $totalProfitUSD = ($price - $cost) * $qty;
//            $totalProfitUSD = number_format((float)$totalProfitUSD, 2, '.', '');
//
//            $totalProfitCAD = ($price - $cost) * $qty;
//
//            // convert currency
//            $curConvert->set_usd($totalProfitUSD);
//
//            $temp = $curConvert->convert();
//
//            $totalProfitCAD = number_format((float)$temp, 2, '.', '');
//
//            $totalCost += $cost;
//            $totalPrice += $price;
//            $totalQty += $qty;
//
//            echo "  <tr>
//                        <td>$sku</td>
//                        <td>$$cost</td>
//                        <td>$$price</td>";
//            if ($qty > 0) {
//                echo "<td style=' color: green;'> $qty</td >";
//
//            } else {
//                echo "<td style=' color: red;'> $qty</td >";
//            }
//
//            if ($profitMargin > 0) {
//                echo "<td style=' color: green;'> $profitMargin%</td >";
//            } else {
//                echo "<td style=' color: red;'> $profitMargin% </td >";
//            }
//
//            if ($totalProfitUSD > 0) {
//                echo "<td style=' color: green;'> $$totalProfitUSD </td >";
//            } else {
//                echo "<td style=' color: red;'> $$totalProfitUSD </td >";
//            }
//
//            if ($totalProfitCAD > 0) {
//                echo "<td style=' color: green;'>  $$totalProfitCAD  </td >";
//            } else {
//                echo "<td style=' color: red;'> $$totalProfitCAD  </td >";
//            }
//
//            $totalProfitUSDAccumulator += $totalProfitUSD;
//            $totalProfitCADAccumulator += $totalProfitCAD;
//            $counter++;
//        }

        if(sizeof($this->key_value_array['sku']) > 0) {
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


            echo "  
      
      <tr >
    
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