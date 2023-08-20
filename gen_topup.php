<?php
include "./customer/function.php";
$i = 1;
$r = 1000;
$c = 0;
$startDate = new DateTime('2023-01-01'); // กำหนดวันที่เริ่มต้น
    $endDate = new DateTime('2023-06-30');   // กำหนดวันที่สิ้นสุด
for ($i; $i <= $r; $i++) {
    $sqlCus = "select cus_id from customer order by rand() limit 1";
    $cusID = connectdb()->query($sqlCus);
    $row = $cusID->fetch_assoc();
    echo $cus_id = $row["cus_id"];

    $numbers = array(50, 100, 200, 500);
    $randomIndex = array_rand($numbers);
    $coin = $numbers[$randomIndex];

    $sqlcoin = select_where("cus_coin", "customer", "cus_id = '$cus_id'");
    if ($sqlcoin->num_rows > 0) {
        $row1 = $sqlcoin->fetch_assoc();
        $sumcoin = $coin + $row1['cus_coin'];
        $result = updatedata("customer", "cus_coin = '$sumcoin'", "cus_id = '$cus_id'");

        if (!$result) {
            die(mysqli_error(connectdb()));
        } else {
            $last_topid = autoid("TOP-", "top_id", "topup", "0000001");
            $sqlins_topup = "insert into topup (top_id,top_cusid,top_amount,top_date)
            values ('$last_topid','$cus_id','$coin',NOW())";
            $result2 = connectdb()->query($sqlins_topup);

            if (!$result2) {
                die(mysqli_error(connectdb()));
            } else {
                $c++;
                
            }
        }
    }
    
}
echo $c;