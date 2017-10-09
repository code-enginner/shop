<?php

    use configReader\jsonReader;
    use functions\Model;

    require_once '../../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'helperFunctions/sql_counter.php';
    require_once root.'vendor/autoload.php';
    if (!is_login())
    {
        header('Location:'._base_url_2.'login.php');
        exit();
    }

    if (!isset($_GET['i']) || intval($_GET['i']) == 0)
    {
        header('Location:'._base_url.'manage.php');
        exit();
    }
    else
    {
        $order_id = strip_tags($_GET['i']);
    }


?>
<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="<?= _base_url_3; ?>assets/lib/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?= _base_url_3; ?>assets/lib/bootstrap-3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?= _base_url_3; ?>assets/style/_font.css">
    <link rel="stylesheet" type="text/css" href="<?= _base_url_3; ?>assets/style/_reset.css">
    <link rel="stylesheet" type="text/css" href="<?= _base_url_3; ?>assets/style/_print.css">
    <script type="text/javascript" src="<?= _base_url_3; ?>assets/script/myClass.js"></script>
    <script type="text/javascript"> var baseURL = "<?= _base_url; ?>"</script>
    <title>اطلاعات مرسوله</title>
</head>
<body dir="rtl">

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <span id="header_info">مشخصات فرستنده:</span>
            <div id="shop_info">
                <span id="name"><i>نام شرکت: </i> happy shop </span>
                <span id="phone_number"><i>شماره تماس شرکت:</i> 09125438744</span>
                <p id="address"><i>آدرس شرکت:</i> تهران - خیابان ولیعصر - پلاک 12</p>
            </div>
            <span id="header_info">مشخصات خریدار: <i id="note">(گیرنده)</i></span>
            <table>
                <tr>
                    <th>نام و نام خانوادگی</th>
                    <th>محصولات</th>
                    <th>قیمت کل</th>
                    <th>تاریخ و ساعت</th>
                    <th>شماره تماس مشتری</th>
                    <th>آدرس مشتری</th>
                </tr>

                <?php
                    $data =
                        [
                            'fields' => [],
                            'values' => [$order_id],
                            'query' => 'SELECT * FROM `user_order` WHERE `user_order`.`order_id` = ?;'
                        ];
                    $result = Model::run() -> c_find($data);
                    if ($result)
                    {
                        for ($i = 0; $i < count($result); $i++)
                        {
                            echo '
                            <tr>
                                <td>'.$result[$i]['user_full_name'].'</td>
                                <td>'.getProductName($result[$i]['order_id']).'</td>
                                <td>'.priceCounter($result[$i]['order_id']).' تومان</td>
                                <td>'.$result[$i]['date'].'</td>
                                <td>'.$result[$i]['user_phone'].'</td>
                                <td>'.$result[$i]['address'].'</td>
                            </tr>
                        ';
                        }
                    }
                ?>
            </table>
        </div>

        <div id="print_form" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <button onclick="print_info()">چاپ اطلاعات</button>
        </div>
    </div>
</div>




<script type="text/javascript" src="<?= _base_url_3; ?>assets/lib/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= _base_url_3; ?>assets/lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>

<script type="text/javascript" language="JavaScript">
    function print_info()
    {
        window.print();
    }
</script>
</body>
</html>
<?php
