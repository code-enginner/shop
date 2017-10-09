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
    <link rel="stylesheet" type="text/css" href="<?= _base_url_3; ?>assets/style/_order_manage.css">
    <script type="text/javascript" src="<?= _base_url_3; ?>assets/script/myClass.js"></script>
    <script type="text/javascript"> var baseURL = "<?= _base_url; ?>"</script>
    <title>مدیریت سفارشات</title>
</head>
<body dir="rtl">
<div class="container-fluid">
    <div class="row">
        <div class="">
            <div class="result">
                <?php
                    $sysMsg = jsonReader::reade('systemMessage.json');
                    if (isset($_GET['delOk']) && $_GET['delOk'] == 1)
                    {
                        echo $sysMsg['serverSuccess'][10]['msg10'];
                        unset($_GET['delOk']);
                    }
                    if (isset($_GET['delError']) && $_GET['delError'] == 1)
                    {
                        echo $sysMsg['serverError'][25]['msg25'];
                        unset($_GET['delError']);
                    }

                    if (isset($_GET['delError']) && $_GET['delError'] == 11)
                    {
                        echo $sysMsg['serverError'][25]['msg25'];
                        unset($_GET['delError']);
                    }
                    if (isset($_GET['u']) && $_GET['u'] === 'ok')
                    {
                        echo $sysMsg['serverSuccess'][11]['msg11'];
                        echo '
                            <script>/*window.location.href = baseURL + "manage.php";*/</script>
                        ';
                    }

                    if (isset($_GET['']) && $_GET['u'] === 'wrong')
                    {
                        echo $sysMsg['serverError'][26]['msg26'];
                        echo '
                            <script type="text/javascript" language="JavaScript">
//                                window.location.href = baseURL + "manage_order.php";
                            </script>
                        ';
                    }

                ?>
            </div>
            <table>
                <tr>
                    <th>ردیف</th>
                    <th>تاریخ</th>
                    <th>کد پیگیری</th>
                    <th>کاربر</th>
                    <th>تعداد</th>
                    <th>جمع کل</th>
                    <th>عملیات</th>
                </tr>
                <?php
                    $data =
                        [
                            'fields' => [],
                            'values' => [],
                            'query' => 'SELECT * FROM `user_order` ORDER BY `user_order`.`date`;'
                        ];
                    $result = Model::run() -> c_find($data);
                    for ($i = 0; $i < count($result); $i++)
                    {
                        echo '
                            <tr>
                                <td>'.($i + 1).'</td>
                                <td>'.$result[$i]['date'].'</td>
                                <td>'.$result[$i]['order_id'].'</td>
                                <td>'.$result[$i]['user_full_name'].'</td>
                                <td>'.numberCounter($result[$i]['order_id']).' عدد</td>
                                <td>'.priceCounter($result[$i]['order_id']).' تومان</td>
                                <td>';
                                    if ($result[$i]['status'] == 1)
                                    {
                                        echo '<a href="'._base_url.'change_status.php?i='.$result[$i]['order_id'].'&f=10"><i class="operation delivery" style="background-color: #f1f8e9; color: #8bc34a;">تحویل داده شده ✔</i></a>';
                                    }
                                    else
                                    {
                                        echo '<a href="'._base_url.'change_status.php?i='.$result[$i]['order_id'].'&f=01"><i class="operation delivery" style="background-color: #fff; color: #d81b60;">معلق ✖</i></a>';
                                    }

                                    echo '
                                        <a href="'._base_url.'print.php?i='.$result[$i]['order_id'].'" target="_blank" class="print"><i class="fa fa-print" aria-hidden="true"></i></a>
                                    ';

                                    echo '
                                    <a href="#?" data-id="'.$result[$i]['order_id'].'" class="operation deleteOrder"><i class="operation delete">حذف</i></a>
                                </td>
                            </tr>
                        ';
                    }

                ?>


            </table>
        </div>
    </div>
</div>






<script type="text/javascript" src="<?= _base_url_3; ?>assets/lib/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= _base_url_3; ?>assets/lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" language="JavaScript">
    var deleteOrder = get._class('deleteOrder');
    for (var i = 0; i < deleteOrder.length; i++)
    {
        deleteOrder[i].addEventListener('click', function ()
        {
            var delOrd = confirm('آیا از حذف این سفارش مطمئن هستید؟');
            var order_id= this.getAttribute('data-id');
            if (delOrd === true)
            {
                window.location.href = baseURL + 'order_delete.php?order_id=' + order_id;
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
