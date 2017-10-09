<?php
    use configReader\jsonReader;
    use functions\Model;

    require_once '../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'functions/jdf.php';
    require_once root.'vendor/autoload.php';

    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] === NULL || $_SESSION['user_id'] === '')
    {
        header('Location:'._base_url_2.'index.php');
        exit();
    }

//    if (isset($_GET['tr_c']))
//    {
//        dump($_GET['tr_c'], TRUE);
//    }

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
    <link rel="stylesheet" type="text/css" href="<?= _base_url_2; ?>assets/style/_download_page.css">
    <script type="text/javascript" src="<?= _base_url_2; ?>assets/script/myClass.js"></script>
    <script type="text/javascript" language="JavaScript"> var baseURL = "<?= _base_url; ?>"; </script>
    <title>Document</title>
</head>
<body dir="rtl">

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="success_payment_message">
                <span class="tanks"> پرداخت موفقیت آمیز بود، با تشکر از خرید شما </span>
                <?php
                    if (isset($_SESSION['tracking_code']))
                    {
                        $tracking_code = $_SESSION['tracking_code'];
                        unset($_SESSION['tracking_code']);
                    }
                    else
                    {
                        header('Location:'._base_url_2.'by_download.php?page=0');
                        exit();
                    }
                    echo '<span id="tracking_code">کد پیگیری : <i dir="ltr">'.$tracking_code.'</i></span>';

                ?>

            </div>
            <div>
                <span id="warning"> <i>توجه:</i><i id="u_n"><?= $_SESSION['user_name']; ?> </i>عزیز، این صفحه فقط یک بار قابل دسترس است. در نتیجه، از بستن یا بارگذاری مجدد صفحه در صورتی که تمایل به ماندن در این صفحه را دارید، خودداری کنید. </span>
                <div class="description">
                    <span id="offer"> روشهای توصیه شده برای دانلود </span>
                    <span id="way_1" class="ways"><i class="number">1)</i> روی نام محصول کیلک راست کرده و گزینه save as را بزنید. </span>
                    <span id="way_2" class="ways"> <i class="number">2)</i>روی نام محصول کیلک راست کرده و گزینه copy link address یا copy link location را انتخاب کنید و بعد لینک دانلود را در نرم افزار IDM، در قسمت Add URL کپی کنید.</span>
                </div>
            </div>
            <table>
                <tr>
                    <th>ردیف</th>
                    <th>نام محصول <i id="hint_download">(برای دانلود، روی نام محصول کلیک کنید)</i></th>
                </tr>
                <?php
                    $params = [];
                    $result = [];
                    $arguments_0 =
                        [
                            'fields' => [],
                            'values' => [$tracking_code],
                            'query' => 'SELECT `payline`.`product_id` FROM `payline` WHERE (`payline`.`tracking_code` = ?);'
                        ];
                    $result_0 = Model::run() -> c_find($arguments_0);
                    if ($result_0)
                    {
                        for ($i = 0; $i < count($result_0); $i++)
                        {
                            $params[] = $result_0[$i]['product_id'];
                        }
                    }

                    for ($j = 0; $j < count($params); $j++)
                    {
                        $arguments =
                            [
                                'fields' => [],
                                'values' => [$params[$j]],
                                'query' => 'SELECT `pay_download`.`download_link`, `pay_download`.`p_name` FROM `pay_download` WHERE `pay_download`.`id` = ?;'
                            ];
                        $result[] = Model::run() -> c_find($arguments);
                    }
                    if (isset($result))
                    {
                        for ($k = 0; $k < count($result); $k++)
                        {
                            echo '
                            <tr>
                                <td>'.($k + 1).'</td>
                                <td><a href="'.$result[$k][0]['download_link'].'">'.$result[$k][0]['p_name'].'</a></td>
                            </tr>
                        ';
                        }
                    }
                ?>
            </table>
        </div>
    </div>
</div>






<script type="text/javascript" src="<?= _base_url_2; ?>assets/lib/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= _base_url_2; ?>assets/lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
<?php
