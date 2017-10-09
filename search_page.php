<?php
    use configReader\jsonReader;
    use functions\Model;

    require_once 'configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';
    require_once root.'user/check_userInput_register.php';
    require_once root.'user/check_userInput_login.php';
    require_once root.'functions/jdf.php';

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
    <link rel="stylesheet" type="text/css" href="<?=_base_url; ?>assets/style/_index.css">
    <link rel="stylesheet" type="text/css" href="<?=_base_url; ?>assets/style/_search_page.css">
    <script type="text/javascript" src="<?= _base_url; ?>assets/script/myClass.js"></script>
    <title>Document</title>
</head>
<body dir="rtl">

<div class="container-fluid">
    <div class="row">

        <div class="top_header col-lg-12 co-md-12 col-ms-12 col-xs-12 clear_fix">
            <span class="search_time"><i class="fa fa-clock-o" aria-hidden="true"></i><?= jdate('l  j  F  Y'); ?></span>
            <a href="<?= _base_url; ?>index.php"><i class="fa fa-home" aria-hidden="true"></i>صفحه اصلی </a>
        </div>

        <section id="main_content" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border-color: transparent;">
            <div id="search_box">
                <form action="" method="GET">
                    <label for=""></label><input type="text" id="" name="product_name" placeholder="نام کالا را وارد کنید" value="<?php if (isset($_GET['product_name'])) {echo $_GET['product_name'];}?>"><button type="submit" name="page" value="0" id="btn_search" class="fa fa-search" aria-hidden="true"></button>
                </form>
            </div>

            <?php

                $product_name = NULL;
                $result = [];
                $sysMsg = jsonReader::reade('systemMessage.json');

                if (isset($_GET['product_name']))
                {
                    if ($_GET['product_name'] === '' || $_GET['product_name'] === NULL)
                    {
                        echo '
                            <script type="text/javascript" language="JavaScript">
                                alert("لطفا نام محصول مورد نظر را بنویسید");                            
                            </script>
                        ';
                        exit();
                    }
                    else
                    {
                        $product_name = htmlspecialchars($_GET['product_name']);
                    }
                }
            ?>


            <div class="finger_slide clear_fix">
                <div class="slide_wrapper clear_fix">
                    <h5 class="slide_product_header unSelect" style="color: #c2185b;">نتایج جستجو</h5>
                    <?php
                        if (isset($product_name))
                        {
                            $page = isset($_GET['page']) ? $_GET['page'] : 0;
                            $data =
                                [
                                    'fields' => [],
                                    'values' => ['%'.$product_name.'%'],
                                    'query' => 'SELECT * FROM `product` WHERE (`product`.`product_name` LIKE ?) ORDER BY `product`.`id` DESC LIMIT '.$page.',4;',
                                ];
                            $result = Model::run() -> c_find($data);
                            if (count($result) == 0)
                            {
                                exit($sysMsg['serverError'][28]['msg28']);
                            }

                            for ($k = 0; $k < count($result); $k++)
                            {
                                echo '
                            <div class="slide_content_wrapper col-lg-3">
                                <a href="' . _base_url . 'showProduct.php?id=' . $result[$k]['id'] . '&tblname=product" target="_blank">
                                    <div class="slide_content">
                                        <div class="slide-img_wrapper"><img src="' . _base_url . 'product_pic/' . $result[$k]['pic'] . '" alt="' . $result[$k]['short_text'] . '" title="' . $result[$k]['short_text'] . '" width="220" height="220" ></div>
                                        <p>' . $result[$k]['short_text'] . '</p>';
                                $all = $result[$k]['rankPlus'] - $result[$k]['rankMines'];
                                $rv = $result[$k]['rankPlus'] + $result[$k]['rankMines'];

                                echo '
                                        <span class="rank"><span id="not"><i class="fa fa-star" aria-hidden="true"></i><i>' . ' ' . $rv . ' ' . '</i></span> از ' . ' ' . $all . ' ' . ' رای </span>
                        ';

                                echo '
                                        <span class="price"> قیمت: <i> ' . $result[$k]['price'] . ' </i> تومان </span>
                                    </div><!-- /.slide_content-->
                                </a>
                                <a href="' . _base_url . 'user/add_to_basket.php?id=' . $result[$k]['id'] . '&n=' . $result[$k]['short_text'] . '&p=' . $result[$k]['price'] . '&pic=' . $result[$k]['pic'] . '" class="add_to_basket"><span ><i class="fa fa-cart-plus" aria-hidden="true"></i></span></a>
                            </div><!-- /.slide_content_wrapper-->
                        ';
                            }
                        }
                    ?>
                </div>
            </div>


            <?php

                if (!isset($_GET['page']))
                {
                    echo '';
                }
                else
                {
                    ?>

                    <div id="_paging" class="clear_fix">
                        <ul class="clear_fix">
                            <?php
                                $all_match =
                                    [
                                        'fields' => [],
                                        'values' => ['%' . $product_name . '%'],
                                        'query' => 'SELECT COUNT(*) FROM `product` WHERE (`product`.`product_name` LIKE ? );',
                                    ];
                                $fetched_all = Model::run()->c_find($all_match);
                                $fetched_all = $fetched_all[0]['COUNT(*)'];

                                $n = 4;
                                for ($j = 0; $j < ceil($fetched_all / $n); $j++)
                                {
                                    echo '
                                <li>
                                    <a href="' . _base_url . 'search_page.php?product_name=' . $product_name . '&page=' . ($n * $j) . '" data-active="' . ($n * $j) . '" class="page">' . ($j + 1) . '</a>
                                </li>
                            ';
                                }
                            ?>
                        </ul>
                    </div>
                    <?php
                }
                    ?>
        </section>
    </div>
</div>







<script type="text/javascript" src="<?= _base_url; ?>assets/lib/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= _base_url; ?>assets/lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= _base_url; ?>assets/script/script_7.js"></script>
<script type="text/javascript" language="JavaScript">
    var page, set, i, temp;

    page = get._class('page');
    set = <?= $_GET['page']; ?>;
    for (i = 0; i < page.length; i++)
    {
        temp = page[i].getAttribute('data-active');
        if (set == temp)
        {
            page[i].classList.add('page_active');
        }
    }
</script>
</body>
</html>
<?php
