<?php

require_once('CurrencyConversion.php');
require_once('DBConnect.php');

class CSVFileReader
{

    public function processCSVFile() {

        $csv_array = [];

        $key_value_array = [];

        $tableName = "";

        if(isset($_POST["submit"])) {
            if (isset($_FILES["file"]["name"])) {
                $filename = explode(".", $_FILES['file']['name']);
            }
            if ($filename[1] == 'csv') {

                $handle = fopen($_FILES['file']['tmp_name'], "r");

                while ($data = fgetcsv($handle)) {

                    $csv_array[] = $data;

                }
                // place row 0 (the Header of .csv file) of csv_array into key_value_array
                foreach ($csv_array[0] as $key => $value) {
                    $key_value_array[$value] = [];
                // loop over csv_array populate values with keys
                for($row = 1; $row < sizeof($csv_array); $row++){
                    $key_value_array[$value][] = $csv_array[$row][$key];
                }

            }
                // now I have an array with header keys as index's
                // And the values

                fclose($handle);

                $DBConnection = new DBConnect(
                    "localhost",
                    "admin",
                    "R1HO8MIdHtAKTDbz",
                    "csvReports" ,
                    "$filename[0]");

                // import to database
                $tableName = $DBConnection->importToDB($key_value_array);

                return $tableName;

            }
        }
    }

}