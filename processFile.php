<?php

require_once('CSVFileReader.php');
require_once('DisplayCSVInfo.php');

$key_value_array = [];

$tableName = "";

$CSVFileReader = new CSVFileReader();

$tableName = $CSVFileReader->processCSVFile();

$DisplayCSVInfo = new DisplayCSVInfo($tableName);

$DisplayCSVInfo->displayData();







