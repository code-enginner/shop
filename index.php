<?php
    use configReader\jsonReader;
    use functions\addCama;
    use functions\Model;
    use functions\Captcha;
    require_once 'configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';
    require_once root.'user/check_userInput_register.php';
    require_once root.'user/check_userInput_login.php';
    require_once root.'functions/jdf.php';
    require_once root.'admin/news_letters/check_registration.php';
    /*unset($_SESSION['lName']);
    unset($_SESSION['fName']);
    unset($_SESSION['email']);*/
    //    unset($_SESSION['user']);

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
    <link rel="stylesheet" type="text/css" href="<?=_base_url; ?>assets/lib/slider/ma5slider.min.css">
    <script type="text/javascript" src="<?= _base_url; ?>assets/script/myClass.js"></script>
    <script type="text/javascript" language="JavaScript">var baseURL = "<?= _base_url; ?>";</script>
    <style type="text/css">

    </style>
    <title>Happy shop</title>
</head>
<body dir="rtl" <?php if (isset($_GET['setback']) && $_GET['setback'] == 1) { echo 'style="overflow: hidden"';} ?>>
<div class="container-fluid">
    <div class="row">
        <?php
            require_once root.'first_top_header.php';
        ?>
        <div class="main_header unSelect col-lg-12">
            <div id="logo" class="col-lg-5 col-md-5 col-sm-5 col-xs-12 pull-right">
                <a href=""><img src="<?= _base_url?>assets/online-shop-vector-logo.png" alt="" title="" width="250" height="250"></a>
            </div> <!-- /#logo-->

            <div id="shop_search" class="col-lg-7 col-md-7 col-sm-7 col-xs-12 pull-right clear_fix">
                <ul class="shop_search_options clear_fix">
                    <li>
                        <?php
                            if (isset($_SESSION['user_id']))
                            {
                                $user_id = intval($_SESSION['user_id']);
                                $data =
                                    [
                                        'fields' => [],
                                        'values' => [$user_id],
                                        'query' => 'SELECT `number` FROM `basket` WHERE `user_id` = ? AND `status` = 0;'
                                    ];
                                $result =  Model::run() -> c_find($data);
                                $temp = [];
                                for ($i = 0; $i < count($result); $i++)
                                {
                                    $temp[] = $result[$i]['number'];
                                }
                                $shop_num = array_sum($temp);
                            }

                            $ui = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
                        ?>
                        <a href="<?= _base_url; ?>user/userPanel.php?ui=<?= $ui; ?>&b=act"><div class="col-lg-6 shop_bag">سبد خرید<i> <?php if (isset($shop_num) && $shop_num > 0) {echo ' ('.$shop_num.') ';} else {echo ' (0) ';}?> </i> <i class="fa fa-shopping-cart" aria-hidden="true"> </i></div></a>
                    </li>

                    <li>
                        <div class="col-lg-6">
                            <div id="b_search" class="b_search">
                                <a href="<?= _base_url; ?>search_page.php"><i class="fa fa-search" aria-hidden="true"></i>جستجوی کالا</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div><!-- /#shop_search-->
        </div><!-- /.main_header-->
        <div class="clear_fix"></div>

        <div id="text_slider">

        </div>

        <nav id="main_menu" class="unSelect clear_fix">
            <?php
                function menu($level = 0)
                {
                    $d_menu =
                        [
                            'fields' => [],
                            'values' => [$level],
                            'query' => 'SELECT * FROM `headleaf` WHERE `headleaf`.`parent_id` = ?;',
                        ];
                    $fetch_menu = Model::run()->c_find($d_menu);
                    for ($t = 0; $t < count($fetch_menu); $t++)
                    {
                        $id = $fetch_menu[$t]['id'];
                        $name = $fetch_menu[$t]['name'];

                        echo '
                                <li><a href="'.$fetch_menu[$t]['address'].'">'.$name.'</a>';
                        $d_menu_2 =
                            [
                                'fields' => [],
                                'values' => [$id],
                                'query' => 'SELECT COUNT(*) FROM `headleaf` WHERE `headleaf`.`parent_id` = ?;',
                            ];
                        $count_sub_menu = Model::run()->c_find($d_menu_2);
                        if ($count_sub_menu[0]['COUNT(*)'] > 0)
                        {
                            echo '
                                <ul>';
                            menu($id);
                            echo '
                                </ul>
                            ';
                        }
                        else
                        {
                            echo '
                                </li>
                            ';
                        }

                    }
                }
            ?>
            <ul class="clear_fix">
                <?php
                    menu();
                ?>
            </ul>
        </nav><!-- /#main_menu-->

        <div class="full_slider unSelect">
            <?php
                echo '';
            ?>
            <h3>slider</h3>
            <div id="mySlider" class="ma5slider hover-navs hover-dots anim-horizontal outside-dots center-dots inside-navs loop-mode autoplay" data-tempo="3500">
                <div class="slides">
                    <a href="#slide-1"><img src="1.jpg" alt="">1</a>
                    <a href="#slide-2"><img src="2.jpg" alt="">2</a>
                    <a href="#slide-3"><img src="3.jpg" alt="">3</a>
                    <a href="#slide-4"><img src="4.jpg" alt="">4</a>
                    <a href="#slide-5"><img src="5.jpg" alt="">5</a>
                </div>
            </div>
        </div><!-- /.full_slider-->
        <div class="clear_fix"></div>

        <section id="main_content" class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
            <div class="finger_slide clear_fix">
                <div class="slide_wrapper clear_fix">
                    <h5 class="slide_product_header unSelect">پرامتیاز ترین ها</h5>
                    <?php
                        $addComa = new addCama();
                        $data_0 =
                            [
                                'fields' => [],
                                'values' => [],
                                'query' => 'SELECT * FROM `product` WHERE ((`product`.`rankPlus` + `product`.`rankMines`) >= 3 ) ORDER BY RAND() LIMIT 4;',
                            ];
                        $is_good = Model::run()->c_find($data_0);
                        for ($k = 0; $k < count($is_good); $k++) {
                            echo '
                                <div class="slide_content_wrapper col-lg-3">
                                    <a href="' . _base_url . 'showProduct.php?id=' . $is_good[$k]['id'] . '&tblname=product" target="_blank">
                                        <div class="slide_content">
                                            <div class="slide-img_wrapper"><img src="' . _base_url . 'product_pic/' . $is_good[$k]['pic'] . '" alt="' . $is_good[$k]['short_text'] . '" title="' . $is_good[$k]['short_text'] . '" width="220" height="220" ></div>
                                            <p>' . $is_good[$k]['short_text'] . '</p>';
                            $all = $is_good[$k]['rankPlus'] - $is_good[$k]['rankMines'];
                            $rv = $is_good[$k]['rankPlus'] + $is_good[$k]['rankMines'];

                            echo '
                                            <span class="rank"><span id="not"><i class="fa fa-star" aria-hidden="true"></i><i>' . ' ' . $rv . ' ' . '</i></span> از ' . ' ' . $all . ' ' . ' رای </span>
                            ';

                            echo '
                                            <span class="price"> قیمت: <i> ' . $is_good[$k]['price'] . ' </i> تومان </span>
                                        </div><!-- /.slide_content-->
                                    </a>
                                    <a href="' . _base_url . 'user/add_to_basket.php?id=' . $is_good[$k]['id'] . '&n=' . strip_tags($is_good[$k]['short_text']) . '&p=' . $is_good[$k]['price'] . '&pic=' . $is_good[$k]['pic'] . '" class="add_to_basket"><span ><i class="fa fa-cart-plus" aria-hidden="true"></i></span></a>
                                </div><!-- /.slide_content_wrapper-->
                            ';
                        }
                    ?>
                </div>
            </div><!-- /.finger_slide-->


            <div class="finger_slide clear_fix">
                <div class="slide_wrapper clear_fix">
                    <?php

                        $arguments_1 =
                            [
                                'data' => [],
                                'tableName' => 'cat',
                                'mathOp' => [],
                                'logicOp' => ['ORDER BY RAND() LIMIT 3'],
                                'fetchAll' => TRUE
                            ];
                        $catNames = Model::run()->find($arguments_1);

                    ?>
                    <h5 class="slide_product_header unSelect"><?php if (isset($catNames)) {
                            echo $catNames[0]['catName'];
                        } ?></h5>
                    <?php
                        $arguments_2 =
                            [
                                'fields' => [],
                                'values' => [$catNames[0]['id']],
                                'query' => 'SELECT * FROM `product` WHERE `cat_id` = ? ORDER BY RAND() LIMIT 4;'
                            ];
                        $product = Model::run()->c_find($arguments_2);

                        for ($j = 0; $j < count($product); $j++) {
                            echo '
                            <div class="slide_content_wrapper col-lg-3">
                                <a href="' . _base_url . 'showProduct.php?id=' . $product[$j]['id'] . '&tblname=product" target="_blank">
                                    <div class="slide_content">
                                        <div class="slide-img_wrapper"><img src="' . _base_url . 'product_pic/' . $product[$j]['pic'] . '" alt="" title="" width="220" height="220" ></div>
                                        <p>' . $product[$j]['short_text'] . '</p>
                                        <span class="rank"><span id="not"><i class="fa fa-star" aria-hidden="true"></i><i> 4 </i></span> از 12 رای </span>
                                        <!--<span class="old_price"><i>15000 <i>تومان</i> </i></span>-->
                                        <span class="price"> قیمت: <i> ' .$product[$j]['price']  . ' </i> تومان </span>
                                    </div><!-- /.slide_content-->
                                </a>
                                <a href="' . _base_url . 'user/add_to_basket.php?id=' . $product[$j]['id'] . '&n=' . strip_tags($product[$j]['short_text']) . '&p=' . $product[$j]['price'] . '&pic=' . $product[$j]['pic'] . '" class="add_to_basket"><span ><i class="fa fa-cart-plus" aria-hidden="true"></i></span></a>
                            </div><!-- /.slide_content_wrapper-->
                        ';
                        }
                        if (isset($_GET['lr']) && $_GET['lr'] === 'ne') {
                            echo '
                            <script type="text/javascript" language="JavaScript">
                                alert("برای خرید محصول ابتدا باید وارد شوید یا ثبت نام کنید.");   
                                window.location.href = "' . _base_url . 'index.php";
                            </script>
                        ';
                        }

                        if (isset($_GET['sb']) && $_GET['sb'] === 'ok') {
                            echo '
                            <script type="text/javascript" language="JavaScript">
                                alert("این کالا با موفقیت به سبد خرید شما اضافه شد.");
                                window.location.href = "' . _base_url . 'index.php";
                            </script>
                        ';
                        }

                        if (isset($_GET['sb']) && $_GET['sb'] === 'w') {
                            echo '
                            <script type="text/javascript" language="JavaScript">
                                alert("متاسفانه فرایند خرید شما با مشکل مواجه شد.");
                                window.location.href = "' . _base_url . 'index.php";
                            </script>
                        ';
                        }

                    ?>
                </div>
            </div><!-- /.finger_slide-->

            <div class="finger_slide clear_fix">
                <div class="slide_wrapper clear_fix">
                    <?php

                        $arguments_1 =
                            [
                                'data' => [],
                                'tableName' => 'cat',
                                'mathOp' => [],
                                'logicOp' => ['ORDER BY RAND() LIMIT 3'],
                                'fetchAll' => TRUE
                            ];
                        $catNames = Model::run()->find($arguments_1);

                    ?>
                    <h5 class="slide_product_header unSelect"><?php if (isset($catNames)) {
                            echo $catNames[1]['catName'];
                        } ?></h5>
                    <?php
                        $arguments_2 =
                            [
                                'fields' => [],
                                'values' => [$catNames[1]['id']],
                                'query' => 'SELECT * FROM `product` WHERE `cat_id` = ? ORDER BY RAND() LIMIT 4;'
                            ];
                        $product = Model::run()->c_find($arguments_2);

                        for ($j = 0; $j < count($product); $j++) {
                            echo '
                            <div class="slide_content_wrapper col-lg-3">
                                <a href="' . _base_url . 'showProduct.php?id=' . $product[$j]['id'] . '&tblname=product" target="_blank">
                                    <div class="slide_content">
                                        <div class="slide-img_wrapper"><img src="' . _base_url . 'product_pic/' . $product[$j]['pic'] . '" alt="" title="" width="220" height="220" ></div>
                                        <p>' . $product[$j]['short_text'] . '</p>
                                        <span class="rank"><span id="not"><i class="fa fa-star" aria-hidden="true"></i><i> 4 </i></span> از 12 رای </span>
                                        <span class="price"> قیمت: <i> ' . $product[$j]['price'] . ' </i> تومان </span>
                                    </div>
                                </a>
                                <a href="' . _base_url . 'user/add_to_basket.php?id=' . $product[$j]['id'] . '&n=' . strip_tags($product[$j]['short_text']) . '&p=' . $product[$j]['price'] . '&pic=' . $product[$j]['pic'] . '" class="add_to_basket"><span ><i class="fa fa-cart-plus" aria-hidden="true"></i></span></a>
                            </div>
                        ';
                        }

                        if (isset($_GET['lr']) && $_GET['lr'] === 'ne') {
                            echo '
                            <script type="text/javascript" language="JavaScript">
                                alert("برای خرید محصول ابتدا باید وارد شوید یا ثبت نام کنید.");   
                                window.location.href = "' . _base_url . 'index.php";
                            </script>
                        ';
                        }

                        if (isset($_GET['sb']) && $_GET['sb'] === 'ok') {
                            echo '
                            <script type="text/javascript" language="JavaScript">
                                alert("این کالا با موفقیت به سبد خرید شما اضافه شد.");
                                window.location.href = "' . _base_url . 'index.php";
                            </script>
                        ';
                        }

                        if (isset($_GET['sb']) && $_GET['sb'] === 'w') {
                            echo '
                            <script type="text/javascript" language="JavaScript">
                                alert("متاسفانه فرایند خرید شما با مشکل مواجه شد.");
                                window.location.href = "' . _base_url . 'index.php";
                            </script>
                        ';
                        }

                    ?>
                </div>
            </div><!-- /.finger_slide-->

            <div class="finger_slide clear_fix">
                <div class="slide_wrapper clear_fix">
                    <?php

                        $arguments_1 =
                            [
                                'data' => [],
                                'tableName' => 'cat',
                                'mathOp' => [],
                                'logicOp' => ['ORDER BY RAND() LIMIT 4'],
                                'fetchAll' => TRUE
                            ];
                        $catNames = Model::run()->find($arguments_1);

                    ?>
                    <h5 class="slide_product_header unSelect"><?php if (isset($catNames)) {
                            echo $catNames[2]['catName'];
                        } ?></h5>
                    <?php
                        $arguments_2 =
                            [
                                'fields' => [],
                                'values' => [$catNames[2]['id']],
                                'query' => 'SELECT * FROM `product` WHERE `cat_id` = ? ORDER BY RAND() LIMIT 4;'
                            ];
                        $product = Model::run()->c_find($arguments_2);

                        for ($j = 0; $j < count($product); $j++) {
                            echo '
                            <div class="slide_content_wrapper col-lg-3">
                                <a href="' . _base_url . 'showProduct.php?id=' . $product[$j]['id'] . '&tblname=product" target="_blank">
                                    <div class="slide_content">
                                        <div class="slide-img_wrapper"><img src="' . _base_url . 'product_pic/' . $product[$j]['pic'] . '" alt="" title="" width="220" height="220" ></div>
                                        <p>' . $product[$j]['short_text'] . '</p>
                                        <span class="rank"><span id="not"><i class="fa fa-star" aria-hidden="true"></i><i> 4 </i></span> از 12 رای </span>
                                        <span class="price"> قیمت: <i> ' . $product[$j]['price'] . ' </i> تومان </span>
                                    </div>
                                </a>
                                <a href="' . _base_url . 'user/add_to_basket.php?id=' . $product[$j]['id'] . '&n=' . strip_tags($product[$j]['short_text']) . '&p=' . $product[$j]['price'] . '&pic=' . $product[$j]['pic'] . '" class="add_to_basket"><span ><i class="fa fa-cart-plus" aria-hidden="true"></i></span></a>
                            </div>
                        ';
                        }

                        if (isset($_GET['lr']) && $_GET['lr'] === 'ne') {
                            echo '
                            <script type="text/javascript" language="JavaScript">
                                alert("برای خرید محصول ابتدا باید وارد شوید یا ثبت نام کنید.");   
                                window.location.href = "' . _base_url . 'index.php";
                            </script>
                        ';
                        }

                        if (isset($_GET['sb']) && $_GET['sb'] === 'ok') {
                            echo '
                            <script type="text/javascript" language="JavaScript">
                                alert("این کالا با موفقیت به سبد خرید شما اضافه شد.");
                                window.location.href = "' . _base_url . 'index.php";
                            </script>
                        ';
                        }

                        if (isset($_GET['sb']) && $_GET['sb'] === 'w') {
                            echo '
                            <script type="text/javascript" language="JavaScript">
                                alert("متاسفانه فرایند خرید شما با مشکل مواجه شد.");
                                window.location.href = "' . _base_url . 'index.php";
                            </script>
                        ';
                        }

                    ?>
                </div>
            </div><!-- /.finger_slide-->


        </section>


        <aside id="side_right" class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
            <h5 id="news_header">تازه ها در happy shop</h5>
            <div id="news_wrapper">
                <?php
                    $data_1001 =
                        [
                            'fields' => [],
                            'values' => [],
                            'query' => 'SELECT * FROM `news` WHERE `news`.`status` = 1 ORDER BY `news`.`id` DESC;'
                        ];
                    $fetch_news =  Model::run() -> c_find($data_1001);
                    if ($fetch_news)
                    {
                        for ($i = 0; $i < count($fetch_news); $i++)
                        {
                            echo '
                                <a href="#"><p class="text_content">'.$fetch_news[$i]['text'].'</p></a>
                            ';
                        }
                    }
                ?>
            </div>

        </aside>
    </div>
</div>

<footer class="container-fluid">
    <div class="row">
        <div id="contact_use" class="unSelect col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <ul class="pull-left">
                <li><span id="tel"> 09128445319 <i class="fa fa-phone" aria-hidden="true"></i></span></li>
                <li><span id="email"> sina.us.2019@gmail.com <i class="fa fa-envelope" aria-hidden="true"></i></span></li>
            </ul>
        </div>

    </div>

    <div class="row">
        <div class="social_net unSelect col-lg-3">
            <div id="social_net_content">
                <ul class="clear_fix">
                    <li><a href="#?"><i class="fa fa-telegram fa-3x" aria-hidden="true"></i></a></li>
                    <li><a href="#?"><i class="fa fa-instagram fa-3x" aria-hidden="true"></i></a></li>
                    <li><a href="#?"><i class="fa fa-facebook-official fa-3x" aria-hidden="true"></i></a></li>
                    <li><a href="#?"><i class="fa fa-twitter-square fa-3x" aria-hidden="true"></i></a></li>
                    <li><a href="#?"><i class="fa fa-google-plus-square fa-3x" aria-hidden="true"></i></a></li>
                </ul>
            </div>
        </div>

        <div class="news_letter col-lg-3">
            <div>
                <h5 id="news_letter_header">خبرنامه</h5>
                <p id="des">از تخفیف ها و جدیدترین ها با خبر شوید!</p>
                <div id="news_letter_content">
                    <form action="" method="post">
                        <div class="input-group">
                            <input type="text" class="form-control" name="register_me" placeholder="ایمیل خود را وارد کنید">
                            <span class="input-group-btn">
                                <button class="btn btn-default fa fa-paper-plane" name="register_news_letters" aria-hidden="true" type="submit"></button>
                            </span>
                        </div><!-- /input-group -->
                    </form>
                </div><!-- /#news_letter_content-->
            </div>

            <div class="register_news_letters_result">
                <?php
                    if (isset($_POST['register_news_letters']) && isset($_POST['register_me']))
                    {
                        $sysMsg = jsonReader::reade('systemMessage.json');
                        if ($_POST['register_me'] === '' || $_POST['register_me'] === NULL)
                        {
                            echo $sysMsg['serverError'][29]['msg29'];
                        }
                        else
                        {
                            $_POST = array_slice($_POST, 0, count($_POST) - 1);
                            $registration_result = call_user_func_array('check_email', array($_POST));
                        }
                    }
                ?>
            </div>

        </div><!-- /.news_letter-->


        <div class="col-lg-3"></div>

        <div id="about_us" class="unSelect col-lg-3">
            <span class="about_us_header"> درباره ما - Happy shop</span>
            <div class="about_us_content">
                <p>این شرکت فعالیت خود را در سال 95 آغاز کرده و تا کنون مورد رضایت مشتریان زیادی قرار گرفته. در این فروشگاه تمام تلاش خود را برای رضایت شما به کار گرفته ایم. </p>
                <ul class="clear_fix">
                    <li><a href="#?" title=""><img src="<?= _base_url?>assets/namad.png" alt="" title="" width="" height=""></a></li>
                </ul>
            </div><!-- /.about_us_content-->
        </div><!-- /.about_us-->
    </div>

    <div id="copy" class="unSelect">
        <p>تمامی حقوق این سایت محفوظ است و هرگونه استفاده تجاری از این وب سایت و محتوای آن، پیگرد قانونی دارد.</p>
        <span>Copyright &copy; 2016 - <i><?= date('Y'); ?></i> Happyshop.com | powered by [ sina ] All Rights Reserved</span>
    </div>
</footer>

<script type="text/javascript" src="<?= _base_url; ?>assets/lib/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= _base_url; ?>assets/lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= _base_url; ?>assets/lib/slider/ma5slider.min.js"></script>
<script type="text/javascript" src="<?= _base_url; ?>assets/script/script.js"></script>
<script type="text/javascript" src="<?= _base_url; ?>assets/script/script_4.js"></script>
<script type="text/javascript" language="JavaScript">
    var searchBTN = get._id('search');
    searchBTN. addEventListener('click', function ()
    {
        var p_name = get._id('p_name').value;
        window.location.href = baseURL + "search_page.php?page=0&pn=" + p_name;
    });
</script>

<script type="text/javascript" language="JavaScript">

</script>
</body>
</html>