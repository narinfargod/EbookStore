<?php
include "./customer/function.php";
$i = 1;
$r = 100;
$c = 0;

for ($i; $i <= $r; $i++) {
    $lastid = autoid("PUB-", "pub_id", "publisher", "0000001");

    $penname = "penN_" . $i;

    $sqlCus = "select cus_id from customer order by rand() limit 1";
    $cusID = connectdb()->query($sqlCus);
    $row = $cusID->fetch_assoc();
    $cus_id = $row["cus_id"];

    $numbers = array("BANK-001", "BANK-002", "BANK-003");
    $randomIndex = array_rand($numbers);
    $bank = $numbers[$randomIndex];

    $acc = sprintf('%010d', rand(0, 9999999999));

    $startTimestamp = strtotime("2019-01-01");
    $endTimestamp = strtotime("2022-12-31");
    $randomTimestamp = rand($startTimestamp, $endTimestamp);
    $randomDate = date("Y-m-d", $randomTimestamp);

    $values = "pub_id,pub_name,pub_account,pub_date,pub_cusid,pub_bankid,pub_round,pub_dinc,pub_instatus";
    $data = "'$lastid','$penname','$acc','$randomDate','$cus_id','$bank','ROU-001','$randomDate','0'";
    if (insertdata("publisher", $values, $data)) $c++;
}
echo "<br>" . $c;
