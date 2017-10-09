<?php
    use configReader\jsonReader;
    use functions\Model;

    require_once '../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';
    require_once root.'functions/jdf.php';
    require_once root.'helperFunctions/sql_counter.php';
    require_once root.'functions/payFunctions.php';

    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] === '' || $_SESSION['user_id'] === NULL)
    {
        header('Location:'._base_url_2.'by_download.php?lg=no');
        exit();
    }
    else
    {
        $user_id = $_SESSION['user_id'];
    }

?>
<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="<?= _base_url_2; ?>assets/lib/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?= _base_url_2; ?>assets/lib/bootstrap-3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?= _base_url_2; ?>assets/style/_font.css">
    <link rel="stylesheet" type="text/css" href="<?= _base_url_2; ?>assets/style/_reset.css">
    <link rel="stylesheet" type="text/css" href="<?=_base_url_2; ?>assets/style/_by_download.css">
    <script type="text/javascript" src="<?= _base_url_2; ?>assets/script/myClass.js"></script>
    <script type="text/javascript" language="JavaScript">var baseURL = "<?= _base_url; ?>";</script>
    <title>Document</title>
</head>
<body dir="rtl">


<div class="container-fluid">
    <div class="row">
        <div class="top_header col-lg-12 co-md-12 col-ms-12 col-xs-12 clear_fix">
            <span class="search_time"><i class="fa fa-clock-o" aria-hidden="true"></i><?= jdate('l  j  F  Y'); ?></span>
            <a href="<?= _base_url_2; ?>index.php"><i class="fa fa-home" aria-hidden="true"></i>صفحه اصلی </a>
            <a id="go_to_basket" href="<?= _base_url_2; ?>by_download.php?page=0"><i class="fa fa-reply-all" aria-hidden="true"></i>لیست محصولات دانلودی</a>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php
                if (isset($_POST['status']) && ($_POST['status'] == 0 || $_POST['status'] == -5))
                {
                    echo '<div class="alert alert-danger warning"><h5><i class="fa fa-window-close"></i><i class="break_line"></i>تراکنش با خطا مواجه شده است.</h5></div>';
                    header('refresh:1;url='._base_url.'basket_links_payment.php');
                    exit();
                }

                if (isset($_POST['status']) && $_POST['status'] == -3)
                {

                    echo '<div class="alert alert-danger warning"><h5><i class="fa fa-window-close"></i><i class="break_line"></i>مشکلی در عملیات بانکی رخ داده است.</h5></div>';
                    header('refresh:1;url='._base_url.'basket_links_payment.php');
                    exit();
                }

                if (isset($_POST['status']) && $_POST['status'] == -4)
                {
                    echo '<div class="alert alert-danger warning"><h5><i class="fa fa-window-close"></i><i class="break_line"></i>فروشنده غیر فعال می باشد.</h5></div>';
                    header('refresh:1;url='._base_url.'basket_links_payment.php');
                    exit();
                }

                if (isset($_POST['status']) && $_POST['status'] == 1)
                {
                    /*** verify ***/
                    $api = 'test';
                    $transId =  $_POST['transId'];
                    $final_result = verify($api,$transId);
                    $final_result = json_decode($final_result);
//                    dump($final_result);
                }
            ?>
            <?php

                if (isset($final_result) && $final_result->status == 1)
                {
                    $final_args_2 =
                        [
                            'fields' => [],
                            'values' => [$user_id],
                            'query' => 'UPDATE `user_order_links` SET `user_order_links`.`status` = 1 WHERE (`user_order_links`.`user_id` = ? AND `user_order_links`.`status` = 0);'
                        ];
                    $before_to_download = Model::run()->c_find($final_args_2);
                    if ($before_to_download)
                    {
                        $lastData_0 =
                            [
                                'fields' => [],
                                'values' => [$user_id],
                                'query' => 'SELECT `user_order_links`.`id` FROM `user_order_links` WHERE (`user_order_links`.`user_id` = ? AND `user_order_links`.`status` = 1 ) ORDER BY `user_order_links`.`id` DESC;'
                            ];
                        $fetch_order_id = Model::run()->c_find($lastData_0);
                        if ($fetch_order_id)
                        {
                            $order_id = $fetch_order_id[0]['id'];
                            $final_args_3 =
                                [
                                    'fields' => [],
                                    'values' => [$fetch_order_id[0]['id'], $user_id],
                                    'query' => 'UPDATE `payline` SET `payline`.`status` = ? WHERE (`payline`.`user_id` = ? AND `payline`.`status` = 0);'
                                ];
                            $ready_to_download = Model::run()->c_find($final_args_3);
                            if ($ready_to_download)
                            {
                                $tracking_code = $fetch_order_id[0]['id'] . '-' . random_int(0, 1000000) . '-' . time();
                                unset($_SESSION['tracking_code']);
                                $_SESSION['tracking_code'] = $tracking_code;
                                $lastData =
                                    [
                                        'fields' => [],
                                        'values' => [$tracking_code, $user_id, $order_id],
                                        'query' => 'UPDATE `payline` SET `payline`.`tracking_code` = ? WHERE (`payline`.`user_id` = ? AND `payline`.`status` = ?);'
                                    ];
                                $set_tracking_code = Model::run()->c_find($lastData);
                                if ($set_tracking_code)
                                {
                                    header('Location:' . _base_url . 'download_page.php');
                                    exit();
                                }
                            }
                        }
                    }
                }

                if (!isset($final_result) || (isset($final_result) && $final_result->status < 0))
                {
                    ?>
                    <table>
                        <tr>
                            <th>ردیف</th>
                            <th>نام محصول</th>
                            <th>تعداد</th>
                            <th>قیمت</th>
                            <th>حذف</th>
                        </tr>
                        <?php
                            $all_price = 0;
                            $all_number = 0;
                            $result = NULL;
                            $arguments =
                                [
                                    'fields' => [],
                                    'values' => [$user_id],
                                    'query' => 'SELECT * FROM `payline` WHERE `payline`.`user_id` = ? AND `payline`.`status` = 0'
                                ];
                            $result = Model::run()->c_find($arguments);
                            if ($result)
                            {
                                for ($i = 0; $i < count($result); $i++)
                                {
                                    $all_number += intval(numberCounter_2($result[$i]['product_id'], $user_id));
                                    $all_price += intval(priceCounter_2($result[$i]['product_id'], $user_id));

                                    echo '
                                <tr>
                                    <td>' . ($i + 1) . '</td>
                                    <td>' . $result[$i]['product_name'] . '</td>
                                    <td>' . $result[$i]['number'] . ' عدد</td>
                                    <td>' . $result[$i]['price'] . ' تومان</td>
                                    <td><a href="#?" data-id="' . $result[$i]['product_id'] . '" class="delete">حذف</a></td>
                                </tr>
                            ';
                                }
                            }
                        ?>
                    </table>
                    <hr>
                    <table id="tbl_result">
                        <tr>
                            <th>مجموع کالاها</th>
                            <th>مبلغ کل</th>
                            <th>ثبت نهایی و ادامه خرید</th>
                        </tr>
                        <?php
                            if (isset($result) && count($result) > 0) {
                                $rial = 0;
                                echo '
                            <tr>
                                <td>' . $all_number . ' عدد</td>
                                <td>' . $all_price . ' تومان</td>
                                <td><a href="' . _base_url . 'sing_purchase_pay_links.php" id="pay">تکمیل خرید</a></td>
                            </tr>
                        ';
                                $_SESSION['all_price'] = $all_price . $rial;
                            }
                        ?>
                    </table>
                    <?php
                }
            ?>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?= _base_url_2; ?>assets/lib/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= _base_url_2; ?>assets/lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" language="JavaScript">
    var delete_p = get._class('delete');
    for (var i = 0; i < delete_p.length; i++)
    {
        delete_p[i].addEventListener('click', function (e)
        {
            e.preventDefault();
            var id = this.getAttribute('data-id');
            var del_msg = confirm('آیا از حذف این کالا مطمئن هستید؟');
            if (del_msg === true)
            {
                window.location = baseURL + 'delete_basket_links.php?id=' + id;
            }
            else
            {
                window.location.href = '#?';
                return false;
            }
        });
    }
</script>

</body>
</html>
<?php
