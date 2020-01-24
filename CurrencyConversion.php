<?php

class CurrencyConversion {
    private $result;
    private $usd;

    public function set_result($result) {
        $this->result = $result;
    }

    public function set_usd($usd) {
        $this->usd = $usd;
    }


    public function set_cad($cad) {
        $this->cad = $cad;
    }

    public function get_usd() {
        return $this->usd;
    }


    public function get_result() {
        return $this->result;
    }

    public function convert() {
        $CAD_price = 0.00;
        // Fetching JSON
        $req_url = 'https://api.exchangerate-api.com/v4/latest/USD';
        $response_json = file_get_contents($req_url);

// Continuing if we got a result
        if(false !== $response_json) {

            // Try/catch for json_decode operation
            try {

                // Decoding
                $response_object = json_decode($response_json);

                // YOUR APPLICATION CODE HERE, e.g.
                $base_price = $this->usd; // Your price in USD
                $CAD_price = round(($base_price * $response_object->rates->CAD), 2);

            }
            catch(Exception $e) {
                // Handle JSON parse error...
            }

        }

        return $CAD_price;

//
//        // set API Endpoint, access key, required parameters
//        $endpoint = 'convert';
//        $access_key = '703e4fe4d17daeec6f81ce917694f882';
//
//        $from = 'USD';
//        $to = 'CAD';
//
//        $amount = $this->usd;
//
//        $date = date_create()->format('Y-m-d');
//
//
//        // initialize CURL:
//        http://finance.yahoo.com/d/quotes.csv?s=XCDUSD=X&f=sl1d1t1
//        $ch = curl_init('http://data.fixer.io/api/convert'.$endpoint.'?access_key='.$access_key.'&from='.$from.'&to='.$to.'&amount='.$amount.'');
//
////        var_dump('http://data.fixer.io/api/convert'.$endpoint.'?access_key='.$access_key.'&from='.$from.'&to='.$to.'&amount='.$amount.'&date='.$date.'');
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//
//        // get the JSON data:
//        $json = curl_exec($ch);
//        curl_close($ch);
//
//        // Decode JSON response:
//
//        $conversionResult = json_decode($json, true);
//        var_dump( $conversionResult);
//
//
//        // access the conversion result
//       return $conversionResult['result'];
    }


}