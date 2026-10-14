<?php
include ("../jdf.php") ;
require_once "../telegram.php"  ;
?>
<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="
https://cdn.jsdelivr.net/npm/yekan-font@1.0.0/css/yekan-font.min.css
" rel="stylesheet">






    <style>
        body{
            font-family: Yekan;
        }
        .header-confirm{
            background-color: #068b069e !important;
            color: darkslategray !important;
        }
        table{
            margin-top: 40px;
        }
    </style>
</head>
<body>
<div class="container text-center">
    <?php
    $price = $_GET['price'];
    $user_id = $_GET['user_id'];
    //----------------------------
   ?>
    <table class="table table-bordered">
        <thead>
        <tr  >
            <th colspan="2" class="header-confirm" >پرداخت شما با موفقیت انجام شد</th>
        </tr>

        </thead>
        <tbody>
        <tr>
            <th>مبلغ</th>
            <th>
                <?= $price  ?> تومان &nbsp;
            </th>
        </tr>
        <tr>
            <th>آیدی پرداخت کننده</th>
            <th>
                <?= $user_id  ?>
            </th>
        </tr>
        <tr>
            <th>تاریخ و زمان پرداخت</th>
            <th >
                <?= jdate("Y/n/j-H:i:s ")?>
            </th>
        </tr>
        <tr  >
            <th colspan="2" class="footer-confirm bg-dark text-white" > وارد حساب کاربری خود شوید و بروزرسانی اطلاعات را بزنید  </th>
        </tr>

        </tbody>
    </table>
</div>
<script type="text/javascript">
    history.pushState(null , null , location.href);
    window.onpopstate=function (){
        history.go(1);
    }

</script>

</body>
</html>