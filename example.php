<?php

require_once('finex.php');
require_once('config.php');

$getask = json_decode(file_get_contents("https://api.bitfinex.com/v1/pubticker/BTCUSD"), true);
$ask = $getask['ask'];

$getbid = json_decode(file_get_contents("https://api.bitfinex.com/v1/pubticker/BTCUSD"), true);
$bid = $getbid['bid'];

$getavg = json_decode(file_get_contents("https://apiv2.bitcoinaverage.com/indices/global/ticker/BTCUSD"), true);
$avg = $getavg['averages']['day'];

$diff = $avg - $ask;
$diff2 = $bid -  $avg;

if($diff > 2){
//good time to buy
echo "24h Avg: ".$avg."<br>";
echo "Current Ask: ".$ask."<br>";
$trade = new bitfinex($api_key, $api_secret);
$buy = $trade->new_order("BTCUSD", "0.01", "1", "buy", "exchange market");
print_r($buy);
}

if($diff2 > 2){
//good time to sell
echo "24h Avg: ".$avg."<br>";
echo "Current Bid: ".$bid."<br>";
$trade = new bitfinex($api_key, $api_secret);
$sell = $trade->new_order("BTCUSD", "0.01", "1", "sell", "exchange market");
print_r($sell);
}

?>
