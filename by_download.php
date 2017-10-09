<?php

    use configReader\jsonReader;
    use functions\Model;

    require_once 'configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';
    require_once root.'functions/jdf.php';

    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] === '' || $_SESSION['user_id'] === NULL)
    {
        header('Location:'._base_url.'index.php?lr=ne');
        exit();
    }
    else
    {
        $user_id = $_SESSION['user_id'];
    }

    if (!isset($_GET['page']) || $_GET['page'] === '' || $_GET['page'] === NULL)
    {
        header('Location:'._base_url.'index.php');
        exit();
    }

?>
<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="<?= _base_url; ?>assets/lib/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?= _base_url; ?>assets/lib/bootstrap-3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?= _base_url; ?>assets/style/_font.css">
    <link rel="stylesheet" type="text/css" href="<?= _base_url; ?>assets/style/_reset.css">
    <link rel="stylesheet" type="text/css" href="<?=_base_url; ?>assets/style/_by_download.css">
    <script type="text/javascript" src="<?= _base_url; ?>assets/script/myClass.js"></script>
    <script type="text/javascript" language="JavaScript">var baseURL = "<?= _base_url; ?>";</script>
    <script type="text/javascript" language="JavaScript">
        <?php

                if (isset($_GET['lg']) && $_GET['lg'] == 'no')
                {
                    echo '
                        alert("ابتدا باید وارد سایت شوید یا ثبت نام کنید.");
                        var part = window.location.href.split("&");
                        window.location.href = baseURL + "by_download.php?" + part[1];
                    ';
                }
                else
                {
                    if (isset($_GET['add']) && $_GET['add'] == 't')
                    {
                        echo '
                            alert("این محصول به سبد شما اضافه شد.");
                            var part = window.location.href.split("&");
                            window.location.href = baseURL + "by_download.php?" + part[1];
                        ';
                    }

                    if (isset($_GET['erradd']) && $_GET['erradd'] == 't')
                    {
                        echo '
                            alert("ظاهرا مشکلی در افزودن این محصول به سبد خرید شما پیش آمده است.");
                            var part = window.location.href.split("&");
                            window.location.href = baseURL + "by_download.php?" + part[1];
                        ';
                    }
                }

        ?>
    </script>
    <title>Document</title>
</head>
<body dir="rtl">

<div class="container-fluid">
    <div class="row">
        <div class="top_header col-lg-12 co-md-12 col-ms-12 col-xs-12 clear_fix">
            <span class="search_time"><i class="fa fa-clock-o" aria-hidden="true"></i><?= jdate('l  j  F  Y'); ?></span>
            <a href="<?= _base_url; ?>index.php"><i class="fa fa-home" aria-hidden="true"></i>صفحه اصلی </a>
            <?php
                if (isset($_SESSION['user_id']))
                {
                    $user_id = $_SESSION['user_id'];
                    $args =
                        [
                            'fields' => [],
                            'values' => [$user_id],
                            'query' => 'SELECT COUNT(*) FROM `payline` WHERE (`payline`.`user_id` = ? AND `payline`.`status` = 0 AND `payline`.`tracking_code` = 0);'
                        ];
                    $check = Model::run() -> c_find($args);
                    if ($check && $check[0]['COUNT(*)'] > 0)
                    {
                        echo '
                            <a id="go_to_basket" href="'._base_url.'user/basket_links_payment.php"><i class="fa fa-shopping-basket" aria-hidden="true"></i>سبد خرید محصولات دانلودی</a>
                        ';
                    }
                }
            ?>
        </div>

        <div class="main_content col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php

                $page = isset($_GET['page']) ? htmlspecialchars(intval($_GET['page'])) : 0;

                $arguments =
                    [
                        'fields' => [],
                        'values' => [],
                        'query' => 'SELECT * FROM `pay_download` ORDER BY `pay_download`.`id` DESC LIMIT '.$page.',4;'
                    ];
                $result = Model::run() -> c_find($arguments);
                if ($result)
                {
                    for ($i = 0; $i < count($result); $i++)
                    {
                        echo '
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 wrapper">
                            <div class="inner_content" id="">
                                <i class="base-info">نام:</i><span>'.$result[$i]['p_name'].'</span>
                                <i class="base-info">قیمت:</i><span>'.$result[$i]['p_price'].' تومان</span>
                                <i class="base-info">توضیحات اجمالی:</i><span>'.$result[$i]['p_short_text'].'</span>
                                <i class="base-info">توضیحات کامل:</i><div class="wrapper_long_text"><span>'.$result[$i]['p_long_text'].'</span></div>';
                        if ($result[$i]['p_available'] == 1)
                        {
                            echo '
                                <a href="'._base_url.'user/basket_links.php?id='.$result[$i]['id'].'&page='.$_GET['page'].'"><span class="by_me">خرید</span></a>
                            ';
                        }
                        else
                        {
                            echo '
                                <span class="no_available">نا موجود</span>
                            ';
                        }

                        echo '
                            </div>
                            </div>
                        ';
                    }
                }
            ?>
        </div>
        <nav class="col-lg-12 col-md-12 col-sm-12 col-xs-12 clear_fix">
            <ul class="clear_fix">
                <?php
                    $sysMsg = jsonReader::reade('systemMessage.json');
                    $data_0 =
                        [
                            'fields' => [],
                            'values' => [],
                            'query' => 'SELECT COUNT(*) FROM `pay_download`;'
                        ];
                    $all_rows = Model::run() -> c_find($data_0);
                    $all_rows = $all_rows[0]['COUNT(*)'];
                    $in_page = 4;

                    if ($all_rows == 0)
                    {
                        echo $sysMsg['serverError'][28]['msg28'];
                    }

                    for ($j = 0; $j < ceil($all_rows / $in_page); $j++)
                    {
                        echo '<li><a href="'._base_url.'by_download.php?page='.($in_page * $j).'"  class="page" data-active="'.($in_page * $j).'">'.($j + 1).'</a></li>';
                    }
                ?>
            </ul>
        </nav>
    </div>
</div>
<script type="text/javascript" src="<?= _base_url; ?>assets/lib/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= _base_url; ?>assets/lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" language="JavaScript">
    var page, set, i, temp;

    page = get._class('page');
    set = <?= $_GET['page']; ?>;
    for (i = 0; i < page.length; i++)
    {
        temp = page[i].getAttribute('data-active');
        console.log(temp = page[i].getAttribute('data-active'));
        if (set == temp)
        {
            page[i].classList.add('page_active');
        }
    }
</script>
</body>
</html>
<?php
