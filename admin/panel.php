<?php

    /**
     * This is admin panel page
     *
     *
    */
    use functions\Model;

    require_once '../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';
    if (!is_login())
    {
        header('Location:'._base_url.'login.php');
        exit();
    }
    elseif (isset($_SESSION['lName']) && isset($_SESSION['fName']) && isset($_SESSION['email']))
    {
        // Create welcome message to admin
        $name = $_SESSION['fName'];
        $lastName = $_SESSION['lName'];
        $email = $_SESSION['email'];
        $msg = ' سلام '.$name;
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
    <link rel="stylesheet" type="text/css" href="<?= _base_url_2; ?>assets/style/_adminPanel.css">
    <script type="text/javascript" src="<?= _base_url_2; ?>assets/script/myClass.js"></script>
    <title>Document</title>
</head>
<body dir="rtl">

<!-- Model For Admin Logout -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">خروج از سیستم</h4>
            </div>
            <div class="modal-body">
                آیا از سیستم خارج می شوید؟
            </div>
            <div class="modal-footer">
                <button type="button" id="_close" class="btn btn-default" data-dismiss="modal">بله</button>
                <button type="button" id="_cancel" class="btn btn-primary" data-dismiss="modal">خیر</button>
            </div>
        </div>
    </div>
</div>

<!-- Admin Panel Header fixed top menu-->
<div class="container-fluid">
    <div class="row">
        <div class="top_header clear_fix unSelect">
            <nav id="top_right_menu" class="pull-right">
                <ul>
                    <li><a href="#"><?php if (isset($msg)) {echo $msg;} ?></a></li> <!-- admin welcome message -->
                    <li><a href="<?= _base_url_2; ?>index.php" target="_blank">نمایش فروشگاه</a></li>
                    <?php
                        $data =
                            [
                                'fields' => [],
                                'values' => [],
                                'query' => 'SELECT COUNT(*) FROM `comment` WHERE (`comment`.`status` = 0);'
                            ];
                        $result =  Model::run() -> c_find($data);
                        if ($result)
                        {
                            if ($result[0]['COUNT(*)'] > 0)
                            {
                                echo '
                                    <li><a data-toggle="tooltip" data-placement="bottom" title=" '.$result[0]['COUNT(*)'].' پیام جدید " href="#">'.$result[0]['COUNT(*)'].'</a></li>
                                ';
                            }
                            else
                            {
                                echo '
                                    <li><a data-toggle="tooltip" data-placement="bottom" title="هیچ پیام جدیدی نیست" href="#">0</a></li>
                                ';
                            }
                        }

                    ?>

                </ul>
            </nav>

            <nav id="top_left_menu" class="pull-left clear_fix">
                <ul id="Parent" class="clear_fix">
                    <li><a href="#"><img id="small_pic" src="image/small.png" alt="" title="" width="20" height="20"></a></li>
                    <li><a href="#">مدیر</a>

                        <div class="clear_fix"></div>

                        <div id="sub_admin_menu" data-change = '1' class="clear_fix">
                            <div id="wrap_big_pic" class="pull-right clear_fix"><img id="big_pic" src="image/big.png" alt="" title="" width="" height=""></div>

                            <div id="child" class="pull-left clear_fix">
                                <ul class="clear_fix">
                                    <li><a href="#">ویرایش اطلاعات</a></li>
                                    <li><a  data-toggle="modal" data-target="#myModal" id="exit" href="#">خروج</a></li>
                                </ul>
                            </div>
                        </div>

                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>


<?php
    /**
     * Admin panel content
     */
    echo '
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 pull-right content_left">
                    <ul>
                        <li><a class="cms_item" id="test" href="'._base_url.'cat/catManage.php" target="frame">مدیریت دسته ها</a></li>
                        <li><a class="cms_item" id="test" href="'._base_url.'head-leaf/headLeaf.php" target="frame">مدیریت سربرگ ها</a></li>
                        <li><a class="cms_item" href="'._base_url.'product/productManage.php" target="frame">مدیریت محصولات</a></li>
                        <li><a class="cms_item" href="'._base_url.'product/insertProduct.php" target="frame">درج محصولات</a></li>
                        <li><a class="cms_item" href="'._base_url.'users/manage_users.php" target="frame">مدیریت کاربران</a></li>
                        <li><a class="cms_item" href="'._base_url.'comments/manage_comments.php" target="frame">مدیریت نظرات</a></li>
                        <li><a class="cms_item" href="'._base_url.'order/manage_order.php" target="frame">مدیریت سفارشات</a></li>
                        <li><a class="cms_item" href="'._base_url.'online_download_order/manage_online_download.php" target="frame">مدیریت خریدهای دانلودی</a></li>
                        <li><a class="cms_item" href="'._base_url.'news/manage_news.php" target="frame">مدیریت اخبار</a></li>
                        <li><a class="cms_item" href="'._base_url.'product_slider/manage_product_slider.php" target="frame">مدیریت اسلایدر محصولات</a></li>
                        <li><a class="cms_item" href="'._base_url.'pay_product/insert_pay_product.php" target="frame">درج محصولات دانلودی</a></li>
                        <li><a class="cms_item" href="'._base_url.'pay_product/manage_pay_product.php" target="frame">مدیریت محصولات دانلودی</a></li>
                        <li><a class="cms_item" href="'._base_url.'news_letters/manage_news_letters.php" target="frame">مدیریت اعضای خبرنامه</a></li>
                        <li><a class="cms_item" href="'._base_url.'admin_manage_account/manage_account.php" target="frame">حساب مدیر</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 pull-left content_right">
                    <iframe src="" frameborder="1" name="frame" dir="rtl" id="iframe_content"></iframe>
                </div>
                <div class="clear-fix"></div>
            </div>
        </div>  
    ';
?>

<script type="text/javascript" src="<?= _base_url_2; ?>assets/lib/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= _base_url_2; ?>assets/lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= _base_url_2; ?>assets/script/script.js"></script>
</body>
</html>
<?php
