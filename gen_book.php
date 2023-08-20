<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>addbook</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>


<body>
    <form action="gen_book.php" method="post" enctype="multipart/form-data">
        <input type="file" name="file1" class="form-control">COV <br>
        <input type="file" name="file2" class="form-control">PDF <br>
        <input type="file" name="file3" class="form-control">TEST <br>
        <input type="submit" class="btn btn-primary" name="submit" value="บันทึกข้อมูล">
    </form>
</body>

</html>

<?php
if (isset($_POST['submit'])) {
    include "./customer/function.php";
    $i = 101;
    $r = 500;
    $c = 0;

    //upload cover
    $file = $_FILES['file1'];
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];

    //upload pdf
    $file2 = $_FILES['file2'];
    $file_name2 = $file2['name'];
    $file_tmp2 = $file2['tmp_name'];
    $file_size2 = $file2['size'];
    $file_error2 = $file2['error'];


    //upload test pdf
    $file3 = $_FILES['file3'];
    $file_name3 = $file3['name'];
    $file_tmp3 = $file3['tmp_name'];
    $file_size3 = $file3['size'];
    $file_error3 = $file3['error'];
    for ($i; $i <= $r; $i++) {
        $sqlPub = "select pub_id,pub_date from publisher order by rand() limit 1";
        $pubID = connectdb()->query($sqlPub);
        $row = $pubID->fetch_assoc();
        $dateY = date('Y', strtotime($row["pub_date"]));
        $dateM = date('m', strtotime($row["pub_date"]));
        $pub_id = $row["pub_id"];

        $lastid = bookautoid();
        $book = "BookN_" . $i;
        $book_cov = "uploads/$pub_id/$dateY/$dateM/$file_name";
        $book_sum = "sumary: " . $book . $book . $book;
        $book_pri = mt_rand(25, 500);
        $book_con = "pdf/$pub_id/$dateY/$dateM/$file_name2";
        $book_test = "test/$pub_id/$dateY/$dateM/$file_name3";
        $book_dup = $row["pub_date"];
        $book_app = $row["pub_date"];
        $book_stat = '2';
        $book_emp = "EMP-6604001";
        $book_pubid = $row["pub_id"];

        $new_folder1 = './customer/uploads/' . $book_pubid;
        $folder1 = $new_folder1 . '/' . $dateY . '/' . $dateM;
        if (!file_exists($folder1)) {
            mkdir($folder1, 0777, true);
        }


        $new_folder2 = './customer/pdf/' . $book_pubid;
        $folder2 = $new_folder2 . '/' . $dateY . '/' . $dateM;
        if (!file_exists($folder2)) {
            mkdir($folder2, 0777, true);
        }


        $new_folder3 = './customer/test/' . $book_pubid;
        $folder3 = $new_folder3 . '/' . $dateY . '/' . $dateM;
        if (!file_exists($folder3)) {
            mkdir($folder3, 0777, true);
        }
        $col = "book_id,book_name,book_cover,book_summary
                ,book_price,book_content,book_test,book_dateup,
                book_app,book_status,book_empid,book_pubid";
        $value = "'$lastid','$book','$book_cov','$book_sum',
                $book_pri,'$book_con','$book_test','$book_dup',
                '$book_app',$book_stat,'$book_emp','$book_pubid'";


        $cover = $folder1 . '/' . $file_name;
        copy($file_tmp, $cover);

        $pdf = $folder2 . '/' . $file_name2;
        copy($file_tmp2, $pdf);

        $test = $folder3 . '/' . $file_name3;
        copy($file_tmp3, $test);

        if (insertdata("book", $col, $value)) $c++;
    }
    echo "<br>" . $c.$pub_id;
}
