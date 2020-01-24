<?php

require_once('CurrencyConversion.php');

class DBConnect
{
    public $connectionHost;
    public $connectionUser;
    public $connectionPassword;
    public $connectionDatabase;
    public $connectionTable;

    function __construct($connectionHost, $connectionUser, $connectionPassword, $connectionDatabase, $connectionTable)
    {
        $this->connectionHost = $connectionHost;
        $this->connectionUser = $connectionUser;
        $this->connectionPassword = $connectionPassword;
        $this->connectionDatabase = $connectionDatabase;
        $this->connectionTable = $connectionTable;
    }

    function importToDB($key_value_array) {

        $sku = "";
        $cost = 0.00;
        $price = 0.00;
        $qty = 0;
        $profitMargin = 0;
        $avgProfitMargin = 0;
        $totalProfit = 0.00;
        $totalProfitUSD = 0.00;
        $totalProfitCAD = 0.00;

        $counter = 0;

        $tableName = $this->connectionTable;

       // $conn = mysqli_connect("localhost", "admin", "R1HO8MIdHtAKTDbz", "csvReports");
        $conn = mysqli_connect($this->connectionHost, $this->connectionUser, $this->connectionPassword, $this->connectionDatabase);

      /*
       *  Variable: SQLCreateTable
       *  create new table with fileName as table name
       *  use -> 'sku', 'cost', 'price', 'qty', 'profit_margin', 'total_profit_USD', 'total_profit_CAD'
       *  as column names
       *
       */
       $SQLCreateTable = "CREATE TABLE ".$tableName."(sku VARCHAR(11), cost decimal(15,2), price decimal(15,2), qty int, profit_margin decimal(15,2), total_profit_USD decimal(15,2), total_profit_CAD decimal(15,2))";

       $resultCreateTable = mysqli_query($conn, $SQLCreateTable);

       if (! empty($resultCreateTable)) {
           print "success";
           print "CSV data table created";
       } else {
           print "error";
           print "Problem in creating table";
       }

       // loop over key_value_array inverted (columns) insert data into table rows of database
        // loop over the column size of the associative array
        //  $this->key_value_array['sku'] will give the size of the columns needed to display (rows of data)
        for ($col = 0; $col < sizeOf($key_value_array['sku']); $col++) {

            // assign values to variables use mysql escape string to sanitize input
            $sku = mysqli_real_escape_string($conn, $key_value_array['sku'][$col]);
            $cost = mysqli_real_escape_string($conn, $key_value_array['cost'][$col]);
            $price = mysqli_real_escape_string($conn, $key_value_array['price'][$col]);
            $qty = mysqli_real_escape_string($conn, $key_value_array['qty'][$col]);

            // calculate profit margin and currency values
            $curConvert = new CurrencyConversion();

            $profitMargin = intval((($price - $cost) / $price) * 100);
            $totalProfitUSD = ($price - $cost) * $qty;
            $totalProfitUSD = number_format((float)$totalProfitUSD, 2, '.', '');

            $totalProfitCAD = ($price - $cost) * $qty;

            // convert currency
            $curConvert->set_usd($totalProfitUSD);

            $temp = $curConvert->convert();

            $totalProfitCAD = number_format((float)$temp, 2, '.', '');

            // insert values into new $filename table
            // populate to DB

            $sqlInsert = "INSERT into ".$tableName."(sku, cost, price, qty, profit_margin, total_profit_USD, total_profit_CAD)".
                         " values ( " . $sku . "," .
                                        $cost . "," .
                                        $price .  "," .
                                        $qty . "," .
                                        $profitMargin . "," .
                                        $totalProfitUSD . "," .
                                        $totalProfitCAD .
                                        ")";

            $result = mysqli_query($conn, $sqlInsert);
            if (! empty($result)) {
                print "success";
                print "Inserting .csv Data into the Database \n";
            } else {
                print "error";
                print "Problem Inserting CSV Data \n";
            }
        }

        $conn->close();

        return $tableName;

    }

    function getDBData() {

        $displayArray = [];

        /* Attempt MySQL server connection. Assuming you are running MySQL
        server with default setting (user 'root' with no password) */
        // $mysqli = new mysqli("localhost", "root", "", "demo");
        $conn = mysqli_connect($this->connectionHost, $this->connectionUser, $this->connectionPassword, $this->connectionDatabase);

        // Check connection
        if($conn === false){
            die("ERROR: Could not connect. " . $conn->connect_error);
        }

        // Attempt select query execution
        $sql = "SELECT * FROM" . $this->connectionTable;

        if($result = $conn->query($sql)){
            if($result->num_rows > 0){
                while($row = $result->fetch_array()){
                    $displayArray = [
                        'sku' => $row['sku'],
                        'cost' => $row['sku'],
                        'price' => $row['sku'],
                        'qty' => $row['qty'],
                        'profitMargin' => $row['profitMargin'],
                        'totalProfitUSD' => $row['totalProfitUSD'],
                        'totalProfitCAD' => $row['totalProfitCAD'],
                    ];
                }

                // Free result set
                $result->free();
            } else{
                echo "No records matching your query were found.";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . $conn->error;
        }

        // Close connection
        $conn->close();

        return $displayArray;
    }
}