<?php
include "./customer/function.php";
$i = 1;
$r = 5000;
$c = 0;

for ($i; $i <= $r; $i++) {
    $nBook = mt_rand(1, 5);
    $total_price = 0;

    $recid = receiptautoid();
    

    $sqlCus = "select cus_id from customer order by rand() limit 1";
    $cusID = connectdb()->query($sqlCus);
    $row = $cusID->fetch_assoc();
    $cus_id = $row["cus_id"];

    $b_idArray = [];
    $b_priceArray = [];
    $b_appArray = [];

    $sqlBook = "select book_id,book_price,book_app
                        from book group by book_id
                        order by rand() limit $nBook";
    $book = connectdb()->query($sqlBook);
    while ($row = $book->fetch_assoc()) {
        $row['book_id'] . " price: " . $row['book_price'] . ' App: ' . $row['book_app'] . "<br>";

        $b_idArray[] = $row['book_id'];
        $b_priceArray[] = $row['book_price'];
        $b_appArray[] = $row['book_app'];

        $total_price += $row['book_price'];
    }
    $sdate = max($b_appArray);

    $startTimestamp = strtotime($sdate);
    $endTimestamp = strtotime("2023-7-31");
    $randomTimestamp = rand($startTimestamp, $endTimestamp);
    $randomDate = date('Y-m-d H:i:s', $randomTimestamp);

    

    //insert reciept
    $value = "rec_id,rec_total,rec_date,rec_cusid";
    $data = "'$recid',$total_price,'$randomDate','$cus_id'";
    $ins_rec = insertdata('receipt', $value, $data);
    if ($ins_rec) {
        $k = 0;
        for ($j = $k + 1; $j <= sizeof($b_idArray); $j++) {
            //insert detail
            $value = "recd_no,recd_recid,recd_bookid,recd_price";
            $data = "$j,'$recid','$b_idArray[$k]','$b_priceArray[$k]'";
            insertdata('receipt_detail', $value, $data);

            //insert shelf
            $value = "bshelf_bookid,bshelf_cusid,bshelf_status,bshelf_proid";
            $data = "'$b_idArray[$k]','$cus_id',2,null";
            insertdata('bookshelf', $value, $data);
            $k++;
        }
    }
}
echo "FINISH";


