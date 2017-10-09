<?php
    use configReader\jsonReader;
    use functions\Model;

    require_once 'configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';
    require_once root.'user/check_userInput_register.php';
    require_once root.'user/check_userInput_login.php';
    require_once root.'user/check-userInput_comment.php';
    require_once root.'functions/jdf.php';


    if (!isset($_GET['id']) || $_GET['id'] === '' || $_GET['id'] === NULL || ((int)$_GET['id'] == 0) ||!isset($_GET['tblname']) || $_GET['tblname'] === '' || $_GET['tblname'] === NULL || $_GET['tblname'] !== 'product' || ((int)$_GET['tblname']) != 0)
    {
        header('Location:'._base_url.'index.php');
        exit();
    }
    else
    {
        $id = htmlspecialchars(intval($_GET['id']));
        $tableName = htmlspecialchars($_GET['tblname']);

        $arguments_1 =
            [
                'data' => ['id' => $id],
                'tableName' => $tableName,
                'mathOp' => ['='],
                'logicOp' => [],
                'fetchAll' => FALSE
            ];

        $result_product = Model::run() -> find($arguments_1);
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
    <link rel="stylesheet" type="text/css" href="<?= _base_url; ?>assets/style/_show_product.css">
    <link rel="stylesheet" type="text/css" href="<?=_base_url; ?>assets/style/_index.css">
    <script type="text/javascript" src="<?= _base_url; ?>assets/script/myClass.js"></script>
    <script type="text/javascript"> var baseURL = "<?= _base_url; ?>"</script>
    <script language="JavaScript" src="<?= _base_url; ?>assets/lib/ckeditor/ckeditor.js"></script>
    <title>نمایش محصول</title>
</head>
<body dir="rtl">

<div class="container-fluid">
    <div class="row">
        <?php
            require_once root.'first_top_header.php';
        ?>
    </div>
</div>

<div class="container-fluid all">
    <div class="row">

<!--        <nav id="main_menu" class="unSelect clear_fix">-->
<!--            --><?php
////                function menu($level = 0)
////                {
////                    $d_menu =
////                        [
////                            'fields' => [],
////                            'values' => [$level],
////                            'query' => 'SELECT * FROM `headleaf` WHERE `headleaf`.`parent_id` = ?;',
////                        ];
////                    $fetch_menu = Model::run()->c_find($d_menu);
////                    for ($t = 0; $t < count($fetch_menu); $t++)
////                    {
////                        $id = $fetch_menu[$t]['id'];
////                        $name = $fetch_menu[$t]['name'];
////
////                        echo '
////                                <li><a href="'.$fetch_menu[$t]['address'].'">'.$name.'</a>';
////                        $d_menu_2 =
////                            [
////                                'fields' => [],
////                                'values' => [$id],
////                                'query' => 'SELECT COUNT(*) FROM `headleaf` WHERE `headleaf`.`parent_id` = ?;',
////                            ];
////                        $count_sub_menu = Model::run()->c_find($d_menu_2);
////                        if ($count_sub_menu[0]['COUNT(*)'] > 0)
////                        {
////                            echo '
////                                <ul>';
////                            menu($id);
////                            echo '
////                                </ul>
////                            ';
////                        }
////                        else
////                        {
////                            echo '
////                                </li>
////                            ';
////                        }
////
////                    }
////                }
//            ?>
<!--            <ul class="clear_fix">-->
<!--                --><?php
////                    menu();
//                ?>
<!--            </ul>-->
<!--        </nav><!-- /#main_menu-->


        <?php
            if (!isset($result_product[0]) || count($result_product[0]) === 0)
            {
                header('Location:'._base_url.'index.php');
                exit();
            }
        ?>


        <div class="img_product col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-right">
            <div class="basic_pic_wrapper"><a href=""><img src="<?= _base_url; ?>product_pic/<?= $result_product[0]['pic']?>" alt="" title="" width="400" height="400"></a></div>
            <div class="more_pic">
                <ul>
                    <li><div><a href=""><img src="<?= _base_url; ?>product_pic/<?= $result_product[0]['pic']?>" alt="" width="70" height="35"></a></div></li>
                    <li><div><a href=""><img src="<?= _base_url; ?>product_pic/<?= $result_product[0]['pic']?>" alt="" width="70" height="35"></a></div></li>
                    <li><div><a href=""><img src="<?= _base_url; ?>product_pic/<?= $result_product[0]['pic']?>" alt="" width="70" height="35"></a></div></li> <!--todo: create [ ... ] for more img-->
                    <li><div><a href=""><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i></a></div></li> <!--todo: create [ ... ] for more img-->
                </ul>
                <div class="clear_fix"></div>

            </div><!-- /.more_pic-->
        </div><!-- /.img_product-->


        <div class="info_dismiss col-lg-8 col-md-8 col-sm-12 col-xs-12 pull-left">
            <div class="top_header">
                <div class="top_wrapper clear_fix">
                    <div class="rank col-lg-3 col-md-3 col-sm-3 col-xs-12 pull-left">
                        <span>
                            امتیاز
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                        </span>
                        <?php
                            $data_2 =
                                [
                                    'fields' => [],
                                    'values' => [$result_product[0]['id']],
                                    'query' => 'SELECT COUNT(`product_id`) FROM `comment` WHERE `product_id` = ?;'
                                ];
                            $result_rank =  Model::run() -> c_find($data_2);
                            $allRank = ' '.$result_rank[0]['COUNT(`product_id`)'].' ';
                        ?>
                        <span><i class="rank_all">از<i><?= $allRank; ?></i>رای</i></span>
                    </div><!-- /.rank-->


                    <div class="base_info col-lg-9 col-md-9 col-sm-9 col-xs-12 pull-right">
                        <span><?= $result_product[0]['product_name']; ?></span>
                    </div><!-- /.base_info-->
                </div><!-- /.top_wrapper-->
                <div class="clear_fix"></div>


                <div class="special_info col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="right col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right">
                        <ul>
                            <li><span><i class="fa fa-paint-brush" aria-hidden="true"></i>رنگ</span>
                                <span class="option_wrapper option_color">
                                    <span class="product_color" style="background-color: <?= $result_product[0]['color']; ?>"></span>
<!--                                    <label class="tic_color" for="color_1" style="background-color: red;"></label><input type="radio" id="color_1" name="valid_color">-->
<!--                                    <label class="tic_color" for="color_2" style="background-color: red;"></label><input type="radio" id="color_2" name="valid_color">-->
<!--                                    <label class="tic_color" for="color_3" style="background-color: red;"></label><input type="radio" id="color_3" name="valid_color">-->
                                </span>
                            </li>
                            <li><span><i class="fa fa-certificate" aria-hidden="true"></i>گارانتی</span>
                                <span class="option_wrapper"><span id="warranty">گارانتی 2 ساله (سازگار، آواژنگ)</span></span>
                            </li>
                            <li><span><i class="fa fa-usd" aria-hidden="true"></i>قیمت</span>
                                <span class="option_wrapper">
                                    <?php
                                        if ($result_product[0]['available'] == 1)
                                        {
                                            echo '
                                                <!--<span class="old_price"><i> 15000 </i>تومان</span>-->
                                                <span class="price">قیمت<i> '.$result_product[0]['price'].' </i> تومان</span>
                                            ';
                                        }
                                        elseif ($result_product[0]['available'] == 0)
                                        {
                                            echo '
                                                <span class="unavailable">نا موجود</span>
                                            ';
                                        }
                                    ?>
                                </span>
                            </li>
                        </ul>
                    </div><!-- /.right-->

                    <div class="middle col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right">
                        <ul>
                            <li><span><i class="fa fa-link" aria-hidden="true"></i>لوازم همراه</span>
                                <span class="option_wrapper"><span class="attached_yes">کیف چرمی فابریک - دفترچه راهنما - شارژر</span></span>
                            </li>
                            <li><span><i class="fa fa-gift" aria-hidden="true"></i>هدایا</span>
                                <span class="option_wrapper"><span class="gift"><i class="gift_no">ندارد</i></span></span><!--todo: اگر ندارد یک نربع کوچک قرمز در غیر این صورت لیست افلام-->
                            </li>
                        </ul>
                    </div><!-- /.middle-->

                    <div class="left col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-left">
                        <ul>
                            <li><span><i class="fa fa-sign-language" aria-hidden="true"></i>پیشنهاد ویژه</span>
                                <span class="option_wrapper"><span class="special_offer"><i class="special_offer_yes">دارد</i></span></span>
                            </li>
<!--                            <li><span><i class="fa fa-clock-o" aria-hidden="true"></i>زمان باقی مانده</span>-->
<!--                                <span class="option_wrapper"><span class="left_time_yes">3 روز و 2 ساعت</span></span>-->
<!--                            </li>-->
<!--                            <li><span>تایمر</span></li>-->
                        </ul>
                    </div><!-- /.left-->
                </div><!-- /.special_info-->
                <div class="clear_fix"></div>
            </div>
            <div class="clear_fix"></div>
            <hr>
            <div class="final col-lg-12">
                <ul class="clear_fix">
                    <?php
                        if (isset($_SESSION['user_id']))
                        {
                            $user_id = intval($_SESSION['user_id']);
                            $data =
                                [
                                    'fields' => [],
                                    'values' => [$user_id],
                                    'query' => 'SELECT `basket`.`number` FROM `basket` WHERE `basket`.`user_id` = ? AND `basket`.`status` = 0;'
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
                    <li><a href="<?= _base_url; ?>user/userPanel.php?ui=<?= $ui; ?>&b=act"><div class="shop_bag">سبد خرید<i> <?php if (isset($shop_num) && $shop_num > 0) {echo ' ('.$shop_num.') ';} else {echo ' (0) ';}?> </i> <i class="fa fa-shopping-cart" aria-hidden="true"> </i></div></a></li>
                    <li><a href="">مقایسه کالا ( به زودی )<i class="fa fa-balance-scale" aria-hidden="true"></i></a></li><!--todo: مقایسه کن-->
                    <li>
                        <?php
                            if (isset($_SESSION['user_id']))
                            {
                                echo '
                                    <a href="'._base_url.'set_rank.php?id='.$result_product[0]['id'].'&tblname=product&plus=1&pr_i='.$result_product[0]['id'].'">
                                        <span>
                                            <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>';

                                        if ($result_product[0]['rankPlus'] === '' || $result_product[0]['rankPlus'] === NULL || $result_product[0]['rankPlus'] == 0)
                                        {
                                            echo '
                                                <i class="_up" aria-hidden="true">0</i>
                                            ';
                                        }
                                        else
                                        {
                                            echo '
                                                <i class="_up" aria-hidden="true">+'.$result_product[0]['rankPlus'].'</i>
                                            ';
                                        }
                                echo '
                                        </span>
                                    </a>';


                                echo '                                               
                                    <a href="'._base_url.'set_rank.php?id='.$result_product[0]['id'].'&tblname=product&mines=1&pr_i='.$result_product[0]['id'].'" class="un_down">
                                        <span>
                                            <i class="fa fa-thumbs-o-down" aria-hidden="true"></i>';



                                if ($result_product[0]['rankMines'] === '' || $result_product[0]['rankMines'] === NULL || $result_product[0]['rankMines'] == 0)
                                {
                                    echo '
                                       <i class="_down" aria-hidden="true">0</i>
                                    ';
                                }
                                else
                                {
                                    echo '
                                       <i class="_down" aria-hidden="true">'.$result_product[0]['rankMines'].'</i>
                                    ';
                                }

                                echo '
                                        </span>
                                    </a>
                                ';
                            }
                        ?>
                    </li>
                </ul>
            </div><!-- /.final-->

            <hr>

            <div class="des_buy_send col-lg-12">
                <ul class="clear_fix">
                    <li><a id="trigger_1" class="tabLink" href="#?" onclick="showContent(event, 'buy')"><i class="fa fa-credit-card" aria-hidden="true"></i>روشهای پرداخت</a></li>
                    <li><a id="trigger_2" class="tabLink" href="#?" onclick="showContent(event, 'send')"><i class="fa fa-truck" aria-hidden="true"></i>روشهای ارسال</a></li>
                    <li><a id="trigger_2" class="add_to_basket" href="<?= _base_url ?>user/add_to_basket.php?id=<?= $result_product[0]['id'];?>&n=<?= $result_product[0]['short_text'];?>&p=<?= $result_product[0]['price'];?>&pic=<?= $result_product[0]['pic'];?>"><i class="fa fa-cart-plus" aria-hidden="true"></i>افزودن به سبد خرید</a></li>
                </ul>

                <div id="buy" class="tabContent pull-right">
                    <span class="fa fa-window-close" aria-hidden="true" onclick="closing(event, 'buy', 'trigger_1')"></span>
                    <p>1- پرداخت از طریق درگاه اینترنتی

                        همگی کاربران دیجی‏‌کالا می‌توانند در هنگام ثبت سفارش، از طریق درگاه اینترنتی بانک‌های سامان و پارسیان در سایت دیجی‌کالا و یا از طریق پنل اینترنت بانک شخصی خود، هزینه سفارش خود را به صورت آنلاین پرداخت و در قسمت پرداخت در سبد خرید ثبت کنند. پرداخت موفق مبلغ به منزله ثبت قطعی این پرداخت برای سفارش است و نیازی به اطلاع دادن آن نیست و سفارش به صورت خودکار وارد مراحل آماده سازی و ارسال می‏‌شود.
                        توجه داشته باشید که تحویل گیرنده سفارش هنگام دریافت کالا، باید کارت شناسایی همراه داشته باشد.
                        لازم به ذکر است که پرداخت اینترنتی باعث ایجاد الویت و تسریع در پردازش سفارش کاربران می‌شود.
                        <br><br>2- پرداخت در محل تحویل

                        به کاربران محترم توصیه می‌شود جهت تسریع در پردازش سفارش، پرداخت خود را به صورت اینترنتی انجام دهند. با وجود این، برای آسودگی بیشتر آن دسته از مشتریانی که تمایل دارند هزینه سفارش خود را هنگام دریافت آن پرداخت کنند، دیجی‏‌کالا این امکان را نیز فراهم آورده است که در صورتی که آدرس تحویل سفارش آنها، تهران یا یکی از شهرهای تحت پوشش تحویل اکسپرس دیجی‌کالا باشد، هزینه را هنگام تحویل گرفتن سفارش، به یکی از روش‌های زیر پرداخت کنند.
                        لازم به ذکر است، سفارش‌هایی که از طریق باربری ارسال می‌شوند یا مبلغ آنها بیشتر از سی میلیون ریال است، لازم است پیش از ارسال، از طریق پرداخت اینترنتی تسویه شوند.</p>
                </div><!-- /#by_description-->

                <div id="send" class="tabContent pull-right">
                    <span class="fa fa-window-close" aria-hidden="true" onclick="closing(event, 'send', 'trigger_2')"></span>
                    <p>سفارش‌ها  در شهر تهران مطابق بازه زمانی که مشتریان هنگام ثبت سفارش انتخاب می‌کنند، تحویل داده خواهد شد. همچنین امکان تحویل سفارش در همه روزهای هفته وجود دارد و سفارش‌‌‌‌های با ارزش بیش از یکصد هزار تومان در شهر تهران رایگان ارسال می‌شوند.
                        در ایام جشنواره، جهت رفاه و آسودگی حال مشتریان عزیز ساکن شهر تهران، امکان انتخاب ارسال توسط پست (علاوه بر ارسال اکسپرس) نیز وجود خواهد داشت و همانند سفارشات اکسپرس در صورتی که ارزش سفارش بیش از یکصد هزار تومان باشد ، ارسال آن رایگان است ولی برای سفارشات زیر یکصدهزار تومان مطابق تعرفه پست در هنگام ثبت سفارش هزینه ارسال دریافت خواهد شد و همچنین پرداخت آنلاین (اینترنتی) برای سفارشاتی که با این سرویس ارسال میشوند الزامی است.
                        این سفارشات با زمان تقریبی بین 24 تا 48 ساعت کاری و با قابلیت رهگیری سفارش و بدون امکان انتخاب بازه‌ی زمان تحویل خواهد شد و لازم به ذکر است این بازه‌ی زمانی برای کالاهایی با فروشندگانی غیر از دیجی‌کالا 48 الی 72 ساعت کاری است.</p>
                </div><!-- /#send_description-->

            </div><!-- /.des_byAnd_send-->

        </div><!-- /.info_dismiss-->
        <div class="clear_fix"></div>


        <div id="my_wrapper" class=" full_info_header col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <ul class="clear_fix">
                <li><a id="tab_review" class="full_info_tabHeader <?php if (!isset($_GET['CR'])) {echo 'active_2';}?>" onclick="tab_link(event, 'review', 'full_info_tab_content_wrapper')" href="#?"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i>نقد و بررسی</a></li>
                <li><a id="tab_technical" class="full_info_tabHeader" onclick="tab_link(event, 'technical', 'full_info_tab_content_wrapper')" href="#?"><i class="fa fa-cogs fa-2x" aria-hidden="true"></i>مشخصات فنی</a></li>
                <li><a id="tab_comment" class="full_info_tabHeader" onclick="tab_link(event, 'comment', 'full_info_tab_content_wrapper')" href="#?"><i class="fa fa-comments-o fa-2x" aria-hidden="true"></i>نظرات کاربران</a></li>
                <li><a id="tab_p_comment" class="full_info_tabHeader <?php if (isset($_GET['CR'])) {echo 'active_2';}?>" onclick="tab_link(event, 'p_comment', 'full_info_tab_content_wrapper')" href="#?"><i class="fa fa-commenting-o fa-2x" aria-hidden="true"></i>ارسال نظر</a></li>
            </ul>
        </div>

        <div class="full_info_tab_content_wrapper clear_fix col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div id="review" class="full_info_tab_content pull-right col-lg-12 col-md-12 col-sm-12 col-xs-12 <?php if (!isset($_GET['CR'])) {echo 'show_content';}?>"><?= $result_product[0]['description']; ?></div>
            <div id="technical" class="full_info_tab_content pull-right col-lg-12 col-md-12 col-sm-12 col-xs-12">محتوای مشخصات فنی</div>
            <div id="comment" class="full_info_tab_content pull-right col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <?php
                    $sysMSG = jsonReader::reade('systemMessage.json');
                   $pr_id = $result_product[0]['id'];
                    $data =
                        [
                            'fields' => [],
                            'values' => [$pr_id],
                            'query' => 'SELECT * FROM `comment` WHERE `product_id` = ? AND `status` = 1;',
                        ];
                    $result_all_comment =  Model::run() -> c_find($data);
                    if ($result_all_comment)
                    {
                        for ($l = 0; $l < count($result_all_comment); $l++)
                        {
                            echo '
                            <div class="comment_wrapper">
                                <div class="sender_name">
                                    <h4 >'.$result_all_comment[$l]['name'].' '.$result_all_comment[$l]['lastName'].'</h4>
                                    <span dir="ltr">'.date('Y / m / d', $result_all_comment[$l]['comment_date']).'</span>
                                </div>
                                <div class="sender_comment">
                                    <p>'.$result_all_comment[$l]['comment'].'</p>
                                </div>
                                <hr>
                            </div>
                        ';
                        }
                    }
                    else
                    {
                        echo $sysMSG['serverError'][23]['msg23'];
                    }

                ?>
            </div>

            <a name="cResultT"></a>
            <a name="cResultF"></a>
            <div id="commentResult">
                <?php
                    if (isset($_POST['send_comment']))
                    {
                        if (!isset($_SESSION['user_id']))
                        {
                            header('Location:'._base_url.'index.php');
                            exit();
                        }
                        // todo: to get the userID most search in data base and then get the userID; >> use the findBy method;
                        // todo: check if the user was send a comment in under 24 hours: if (yes) ? cancel : set the comment;

                        $sysMSg = jsonReader::reade('systemMessage.json');
                        $_POST = array_slice($_POST, 0, count($_POST) - 1);
                        $_POST['productId'] = $result_product[0]['id'];
                        $_POST['productName'] = $result_product[0]['product_name'];
                        $_POST['user_id'] = $user_id;
                        $result_comment = call_user_func_array('check_user_comment', array($_POST));

                        if (isset($result_comment[1]) && $result_comment[1] === FALSE)
                        {
                            echo $result_comment[0];
                            echo '
                                <script type="text/javascript" language="JavaScript">window.location.href = baseURL +"showProduct.php?id='.$id.'&tblname='.$tableName.'&CR=F#cResultF";
                                alert("خطایی در ثبت نظر شما اتفاق فاده است");
                                </script>
                            ';
                        }
                        else
                        {
                            echo $sysMSg['serverSuccess'][9]['msg9'];
                            echo '
                                <script type="text/javascript" language="JavaScript">window.location.href = baseURL + "showProduct.php?id='.$id.'&tblname='.$tableName.'&CR=T#cResultT";
                                alert("نظر شما با موفقیت ثبت شد، پس از تایید، نمایش داده می شود.");
                                </script>
                            ';
                        }
                    }
                ?>
            </div>
            <div id="p_comment" class="full_info_tab_content pull-right col-lg-12 col-md-12 col-sm-12 col-xs-12 <?php if (isset($_GET['CR']) && ($_GET['CR'] === 'T' || $_GET['CR'] === 'F')) {echo 'show_content';}?>">
                <div class="p_comment_wrapper">
                    <?php
                        if (!isset($_SESSION['user_id']))
                        {
                            echo '<div class="alert alert-danger warning"><h5><i class="fa fa-window-close"></i><i class="break_line"></i>برای ثبت نظر، لطفا وارد شوید یا ثبت نام کنید.</h5></div>';
                        }
                        else
                        {
                            echo '
                                <form action="" method="post" disabled="disabled">
                                    <label for="">نام<i class="fa fa-asterisk" aria-hidden="true"></i></label><input type="text" id="" name="userName" placeholder="نام خود را بنویسید">
                                    <label for="">نام خانوادگی<i class="fa fa-asterisk" aria-hidden="true"></i></label><input type="text" id="" name="userLastName" placeholder="نام خانوادگی خود را بنویسید">
                                    <label for="">ایمیل<i class="fa fa-asterisk" aria-hidden="true"></i></label><input type="email" id="" name="userEmail" placeholder="ایمیل خود را بنویسید">
                                    <label for="">وب سایت</label><input type="text" id="" name="userWebsite" placeholder="وب سایت خود را بنویسید">
                                    <label for="">امتیاز<i class="fa fa-asterisk" aria-hidden="true"></i></label>
                                    <select name="userRank" id="user_rank">
                                        <option value="">به این محصول امتیاز دهید</option>
                                        <option value="" disabled></option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                    <label for="">نظر خود را بنویسید<i class="fa fa-asterisk" aria-hidden="true"></i></label><textarea name="userComment" id="ckEditor" cols="30" rows="10"></textarea>
                                    <input type="submit" name="send_comment" value="ارسال نظر"><input type="reset" value="انصراف">
                                </form>
                            ';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="tab_menu"></div>




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
                            <input type="text" class="form-control" placeholder="ایمیل خود را وارد کنید">
                            <span class="input-group-btn">
                                <button class="btn btn-default fa fa-paper-plane" aria-hidden="true" type="button"></button>
                            </span>
                        </div><!-- /input-group -->
                    </form>
                </div><!-- /#news_letter_content-->
            </div>
        </div><!-- /.news_letter-->

        <div class="col-lg-3"></div>

        <div id="about_us" class="unSelect col-lg-3">
            <span class="about_us_header">درباره ما - Happy shop</span>
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
        <span>Copyright &copy; 2016 - <i>2017</i> Happyshop.com | powered by [ sina ] All Rights Reserved </span>
    </div>
</footer>

<script type="text/javascript" src="<?= _base_url; ?>assets/lib/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= _base_url; ?>assets/lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= _base_url; ?>assets/script/script_3.js"></script>
<script type="text/javascript" src="<?= _base_url; ?>assets/script/script_4.js"></script>

<!--<script type="text/javascript" language="JavaScript">-->
<!--//    var wrapper = get._id('my_wrapper');-->
<!--//    wrapper.style.maxheight = wrapper.scrollHeight;-->
<!--</script>-->
<script type="text/javascript" language="JavaScript">
    CKEDITOR.replace('userComment',
        {
            language: 'fa'
        });
</script>

</body>
</html>

<?php
