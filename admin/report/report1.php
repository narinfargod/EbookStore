<?php
include("../func.php");
conn();
session_start();
$pos = $_SESSION['POS'];
if (!isset($_SESSION["ID"])) {
    header("location:../login.php");
}
$row = mysqli_fetch_array(selectWhere('count(*) as permis', 'pos_per', "pp_posid='$pos' "));
$permis = $row['permis'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet"
        type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="../css/styles.css" rel="stylesheet" />
</head>

<body id="page-top">

    <!-- Portfolio Section-->
    <section class="page-section portfolio" id="portfolio">
        <div class="container">
            <!-- Portfolio Section Heading-->
            <div text-align="left">
                <a href="../index.php"><img class="img-fluid" src="../assets/img/portfolio/home.png" width="100" /></a>
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Report 1</h2>
            </div>
            
            <!-- Icon Divider-->
            <div class="divider-custom">

                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>

            <div style="text-align:right">
                <form action="report1.php" method="post">
                    <input type="text" name="search" placeholder="year (example 2023)">
                    <input type="submit" name="submit" value="Search">
                </form>

            </div>
            
        </div>
    </section>
    
    <div style="text-align: center;">
        <table class="table table-hover">
        <h1>Income and Expenses Account</h1>
            <tr>
                <th>DATE</th>
                <th>INCOME</th>
                <th>EXPENSE</th>
                <th>DETAIL</th>
            </tr>
            <?php
            
            $month = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');

            foreach ($month as $m) {
                $i = $m;
                if (isset($_POST['submit'])) {
                    if($_POST['search']==''){
                        $search='Y';
                    }else{
                        $search = $_POST['search'];
                    }
                   // echo $search;
                    $result = selectWhere("top_id,DATE_FORMAT(CURDATE(), '%$search-$i') as date,sum(top_amount) as amount", 'topup', "top_date like DATE_FORMAT(top_date, '%$search-$i%') group by  DATE_FORMAT(CURDATE(), '%$search-$i%')");

                }else{
                    $result = selectWhere("select top_id,DATE_FORMAT(CURDATE(), '%Y-04') as date,sum(top_amount) as amount from topup where top_date like DATE_FORMAT(top_date, '%Y-04%') group by  DATE_FORMAT(CURDATE(), '%Y-04%')");
                    
                }
                
                while ($row = mysqli_fetch_array($result)) {
                    $expense = selectWhere('sum(inc_amount) as amount','income',"inc_date like DATE_FORMAT(inc_date, '%Y-$i%')")->fetch_array();
                    
                    ?>
                    <tr>
                        <td>
                            <?= $row['date'] ?>
                        </td>
                        <td>
                            <?= $row['amount'] ?>
                        </td>
                        <td>
                            <?= number_format($expense['amount'], 2) ?>
                        </td>

                        <td>
                            <?php if ($permis) { ?>

                                <a href="re1_income.php?date=<?= $row["date"] ?>" class="btn btn-primary">Income</a>
                                <a href="re1_expense.php?date=<?= $row["date"] ?>" class="btn btn-danger">Expense</a>
                                <?php $i++;
                            } ?>

                        </td>





                    </tr>
                <?php }
            }
            mysqli_close(conn());
            ?>
        </table>
    </div>

    </div>

    <!-- Copyright Section-->
    <div class="copyright py-4 text-center text-white">
        <div class="container"><small>Copyright &copy; Your Website 2023</small></div>
    </div>


    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>
<?php

?>