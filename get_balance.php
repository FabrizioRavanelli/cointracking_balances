<?php

include 'api.php';

// Test request
$coins = cointracking('getBalance', array('limit' => '200', 'order' => 'DESC', 'start' => 1300000000, 'end' => 1450000000));

include 'upload_balance.php';

echo "<h2><b>Fertig!</b></h2>";

//print_r($coins);

?>