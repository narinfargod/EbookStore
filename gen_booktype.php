<?php
include "./customer/function.php";
$i = 1;
$r = 100;
$c = 0;

//insert ทุกเล่มเสร็จ ให้comment while
/*
$sqlBook = "select book_id from book ";
$bookID = connectdb()->query($sqlBook);
while ($row = $bookID->fetch_assoc()) {
    echo $book_id = $row["book_id"];
    $sqlType = "select type_id from typebook order by rand() limit 1 ";
    $typeID = connectdb()->query($sqlType);
    $row = $typeID->fetch_assoc();
    echo $type_id = $row["type_id"];

    echo "<br>";
    $value = "btype_bookid,btype_typeid";
    $data = "'$book_id','$type_id'";
    insertdata('book_type', $value, $data);
    $c++;
}
*/
//insert เพิ่มเติม
for ($i; $i <= $r; $i++) {
    $sqlBook = "select book_id from book order by rand() limit 1 ";
    $bookID = connectdb()->query($sqlBook);
    $row = $bookID->fetch_assoc();
    echo $book_id = $row["book_id"];
    $sqlType = "select type_id from typebook order by rand() limit 1 ";
    $typeID = connectdb()->query($sqlType);
    $row = $typeID->fetch_assoc();
    echo $type_id = $row["type_id"];

    echo "<br>";
    $value = "btype_bookid,btype_typeid";
    $data = "'$book_id','$type_id'";
    insertdata('book_type', $value, $data);
    $c++;
}

echo $c;;
