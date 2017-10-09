<?php
    use configReader\jsonReader;
    use functions\Model;

    require_once '../../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'helperFunctions/sql_counter.php';
    require_once root.'vendor/autoload.php';
    require_once root.'functions/jdf.php';
    if (!is_login())
    {
        header('Location:'._base_url_2.'login.php');
        exit();
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
    <link rel="stylesheet" type="text/css" href="<?= _base_url_3; ?>assets/style/_manage_online_download.css">
    <script type="text/javascript" src="<?= _base_url_3; ?>assets/script/myClass.js"></script>
    <script type="text/javascript"> var baseURL = "<?= _base_url; ?>"</script>
    <title>Document</title>
</head>
<body dir="rtl">


<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div>
                <h5 id="pay">خریدهای پرداخت شده</h5>
                <span id="got_to_no_pay">نمایش لیست خریدهای پرداخت نشده</span>
            </div>
            <table>
                <tr>
                    <th>ردیف</th>
                    <th>نام کاربر</th>
                    <th>نام محصول</th>
                    <th>تعداد</th>
                    <th>قیمت</th>
                    <th>تاریخ</th>
                    <th>کد رهگیری</th>
                    <th>حذف</th>
                </tr>
                <?php
                    $argument =
                        [
                            'fields' => [],
                            'values' => [],
                            'query' => 'SELECT *, `user_order_links`.`date`, `user_order_links`.`user_full_name` FROM `payline` LEFT JOIN `user_order_links` ON `user_order_links`.`id` = `payline`.`status`  WHERE (`user_order_links`.`status` = 1) ORDER BY `payline`.`id` DESC;'
                        ];
                    $result =  Model::run() -> c_find($argument);
                    if ($result)
                    {
                        for ($i = 0; $i < count($result); $i++)
                        {
                            echo '
                                <tr>
                                    <td>'.($i + 1).'</td>
                                    <td>'.$result[$i]['user_full_name'].'</td>
                                    <td>'.$result[$i]['product_name'].'</td>
                                    <td>'.$result[$i]['number'].' عدد</td>
                                    <td>'.$result[$i]['price'].' تومان</td>
                                    <td>'.jdate('l  j  F  Y, در ساعت  s : i : H', $result[$i]['date']).'</td>
                                    <td>'.$result[$i]['tracking_code'].'</td>
                                    <td><a href="#?" data-id="'.$result[$i]['user_id'].'" class="delete_user">حذف</a></td>
                                </tr>
                            ';
                        }
                    }
                ?>

            </table>
        </div>
    </div>
</div>












<script type="text/javascript" src="<?= _base_url_3; ?>assets/lib/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= _base_url_3; ?>assets/lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" language="JavaScript">
    var delete_user = get._class('delete_user');
    var got_to_no_pay = get._id('got_to_no_pay');

    for (var i = 0; i < delete_user.length; i++)
    {
        delete_user[i].addEventListener('click', function (e)
        {
            e.preventDefault();
            var id = this.getAttribute('data-id');
            var msg = confirm('آیا از حذف این کاربر مطمئن هستید؟');
            if (msg === true)
            {
                window.location.href = baseURL + "delete_user_payline_order.php?id=" + id;
            }
        });
    }

    got_to_no_pay.addEventListener('click', function ()
    {
        window.location.href = baseURL + "unregistered_order.php";
    });
</script>
</body>
</html>
<?php
