<?php

define( 'SHORTINIT', true );

require_once( '../wp-load.php' );

function apply_percentage($value, $percentage)
{
    return $value - ($value*$percentage/100);
}

$wpdb->query('TRUNCATE TABLE mytable');

echo "<h2>Anzahl der Coins zu speichern: " . sizeof($coins["details"]) . "</h2>";

foreach ($coins["details"] as &$info) {
	  unset($info["amount"]);
	  $coin = $info["coin"];
	  $price_btc = $info["price_btc"];
	  $change_next_1h = apply_percentage($info["change1h"],30);
	  $info["change1h"] = $change_next_1h;
	  $change_next_24h = apply_percentage($info["change24h"],20);
	  $info["change24h"] = $change_next_24h;
	  $change_next_7_days = apply_percentage($info["change7d"],40);
	  $info["change7d"] = $change_next_7_days;
	  $change_next_30_days = apply_percentage($info["change30h"],50);
	  $info["change30h"] = $change_next_30_days;
	  
	  $wpdb->insert( 
			'mytable', 
			array( 
				'coin' => $coin, 
				'Price_BTC' => $price_btc,
				'Change_next_1h' => $change_next_1h,
				'Change_next_24h' => $change_next_24h,
				'Change_next_7_days' => $change_next_7_days,
				'Change_next_30_days' => $change_next_30_days,
			)
	  );
}

unset($coins["summary"]);

$coins_data_json = json_encode($coins);

$coins_file = "../coins.json";

//write json data into coins.json file
if(file_put_contents($coins_file, $coins_data_json)) {
	echo '<h2>Save JSON File: Data successfully saved</h2>';
}
else 
	echo "<h2>Error saving JSON File</h2>";

?>