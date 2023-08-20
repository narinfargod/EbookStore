<?php 
include "./customer/function.php";
$i = 1;
$r = 10000;
$c = 0;

for ($i; $i <= $r; $i++) {
    $sqlCus = "select cus_id from customer order by rand() limit 1 ";
    $cusID = connectdb()->query($sqlCus);
    $row = $cusID->fetch_assoc();
    $cus_id = $row["cus_id"];

    $sqlBook = "select book_id from book order by rand() limit 1";
    $bookID = connectdb()->query($sqlBook);
    $row = $bookID->fetch_assoc();
    $book_id = $row["book_id"];

    $score = sprintf('%01d', rand(1, 5));

    $value = "bscore_bookid,bscore_cusid,bscore_score";
    $data = "'$book_id','$cus_id',$score";
    insertdata('bookscore',$value,$data);
}
echo "finish";
?>