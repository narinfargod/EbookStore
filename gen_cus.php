<?php
include "./customer/function.php";
//connectdb();

$i = 43729;
$r = 50000;
$c = 0;
for ($i; $i <= $r; $i++) {
    
    $lastid = autoid('CUS-', 'cus_id', 'customer', '0000001');
    $fname = "CusName_" . $i;
    $lname = "CusLName_" . $i;
    $username = "cus_" . $i;
    $password = "123456";
    $password = hash('sha512', $password);

    $genders = array("M", "F");
    $randomIndex = random_int(0, count($genders) - 1);
    $randomGender = $genders[$randomIndex];

    $email = $lastid . "@mail.com";

    $startTimestamp = strtotime("1990-01-01");
    $endTimestamp = strtotime("2020-12-31");
    $randomTimestamp = rand($startTimestamp, $endTimestamp);
    $randomDate = date("Y-m-d", $randomTimestamp);

    $randomPhoneNumber = sprintf('%010d', rand(0, 9999999999));

    $values = "cus_id,cus_uname,cus_pass,cus_name,cus_lname,cus_sex,cus_bdate,cus_tel,
    cus_email,cus_coin";
    $inputdata = "'$lastid','$username','$password','$fname','$lname','$randomGender','$randomDate','$randomPhoneNumber'
    ,'$email',0";
    $result = insertdata('customer',$values,$inputdata);
    if($result){
        $c++ ;
    }else{
        $c--;
    }
}
echo $c;

    