<?php

    use configReader\jsonReader;
    use functions\Model;

    require_once '../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'functions/jdf.php';
    require_once root.'vendor/autoload.php';
    require_once root.'user/check_update_profile_input.php';


    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] === NULL || $_SESSION['user_id'] === '')
    {
        header('Location:'._base_url_2.'index.php');
        exit();
    }
    else
    {
        $user_id = $_SESSION['user_id'];
    }


    if (!isset($_GET['ui']) || $_GET['ui'] === '' || $_GET['ui'] === NULL)
    {
        header('Location:'._base_url_2.'index.php');
        exit();
    }
    else
    {
        $data =
            [
                'fields' => [],
                'values' => [$user_id],
                'query' => 'SELECT * FROM `basket` WHERE (`user_id` = ? AND `status` = 0);'
            ];
        $result_all_purchases =  Model::run() -> c_find($data);
        //todo: echo class "active_content" to show basket list item in tab content;
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
    <link rel="stylesheet" type="text/css" href="<?= _base_url_2; ?>assets/style/_user_panel.css">
    <script type="text/javascript" src="<?= _base_url_2; ?>assets/script/myClass.js"></script>
    <script type="text/javascript" language="JavaScript"> var baseURL = "<?= _base_url; ?>"; </script>
    <title> پنل کاربری <?=' '.$_SESSION['user_name'].' '; ?></title>
</head>
<body dir="rtl">
<div class="container-fluid">
    <div class="row">
        <div class="first_header col-lg-12 col-md-12 col-sm-12 col-xs-12 clear_fix">
            <ul class="clear_fix">
                <li><span class="user_welcome"><i class="fa fa-address-card" aria-hidden="true"></i> سلام <i class="user_info"><?php echo $_SESSION['user_name']; ?></i> عزیز، خوش آمدی</span></li>
                <li><span class="user_welcome"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i> تاریخ عضویت شما : <i class="user_info"><?= jdate('l  j  F  Y, در ساعت  s : i : H', $_SESSION['user_register_date']); ?></i></span></li>
                <?php
                    if (isset($_SESSION['user_logged_date']) && $_SESSION['user_logged_date'] > 0)
                    {
                        echo'
                            <li><span class="user_welcome"><i class="fa fa-calendar" aria-hidden="true"></i> زمان آخرین ورود شما : <i class="user_info">'.jdate('l  j  F  Y, در ساعت  s : i : H', $_SESSION['user_logged_date']).'</i></span></li>
                        ';
                    }
                ?>
                <li><a href="<?= _base_url_2?>index.php"><i class="fa fa-home" aria-hidden="true"></i>صفحه اصلی</a></li>
                <li><a href="#" id="logout"><i class="fa fa-sign-out" aria-hidden="true"></i>خروج</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="tab_link_wrapper clear_fix">
                <div class="tab_link_content clear_fix">
                    <ul class="clear_fix">
                        <li><a href="#?" id="tab_1" class="tab_link" onclick="tab_switch('tab_1', 'my_comment', event)">نظرات من</a></li>
                        <li><a href="#?" id="tab_2" class="tab_link" onclick="tab_switch('tab_2', 'my_shopping_list', event)">لیست خریدهای من</a></li>
                        <li><a href="#?" id="tab_3" class="tab_link <?php if (isset($_GET['b']) && $_GET['b'] === 'act') {echo 'active_tab';}?>" onclick="tab_switch('tab_3', 'my_basket', event)">سبد خرید من</a></li>
                        <li><a href="#?" id="tab_4" class="tab_link <?php if (!isset($_GET['b'])) {echo 'active_tab';}?>" onclick="tab_switch('tab_4', 'my_profile', event)">پروفایل من</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="tab_content_wrapper clear_fix">
                <div class="tab_content clear_fix">
                    <div id="my_comment" class="tab_content_inner">
                        <table id="tbl_comment">
                            <tr>
                                <th>ردیف</th>
                                <th>نام کالا</th>
                                <th>نظر ارسالی شما</th>
                                <th>امتیاز</th>
                                <th>تاریخ</th>
                            </tr>
                            <?php
                                $arguments =
                                    [
                                        'fields' => [],
                                        'values' => [$user_id],
                                        'query' => 'SELECT * FROM `comment` WHERE (`comment`.`user_id` = ? AND `comment`.`status` = 1) ORDER BY `comment`.`id` DESC;'
                                    ];
                                $result = Model::run()->c_find($arguments);
                                if ($result)
                                {
                                    for ($i = 0 ; $i < count($result); $i++)
                                    {
                                        echo '
                                            <tr>
                                                <td>'.($i + 1).'</td>
                                                <td>'.$result[$i]['product_name'].'</td>
                                                <td>'.$result[$i]['comment'].'</td>
                                                <td>'.$result[$i]['rank'].'</td>
                                                <td>'.jdate('l  j  F  Y, در ساعت  s : i : H', $result[$i]['comment_date']).'</td>
                                            </tr>
                                        ';
                                    }
                                }
                            ?>
                        </table>

                    </div>
                    <div id="my_shopping_list" class="tab_content_inner">
                        <?php
                            $arguments_1 =
                                [
                                    'fields' => [],
                                    'values' => [$user_id],
                                    'query' => 'SELECT * FROM `basket` WHERE (`basket`.`status` > 0 AND `basket`.`user_id` = ?) ORDER BY `basket`.`id` DESC;'
                                ];
                            $result_1 = Model::run() -> c_find($arguments_1);
                            if ($result_1)
                            {
                                $sysMsg = jsonReader::reade('systemMessage.json');
                                if (count($result_1) > 0)
                                {
                                    echo '
                                        <table id="shop_list">
                                            <tr>
                                                <th>ردیف</th>
                                                <th>نام کالا</th>
                                                <th>تعداد</th>
                                                <th>قیمت</th>
                                            </tr>
                                    ';
                                    for ($i = 0; $i < count($result_1); $i++)
                                    {
                                        echo '
                                            <tr>
                                                <td>'.($i + 1).'</td>
                                                <td>'.$result_1[$i]['bought_product_name'].'</td>
                                                <td>'.$result_1[$i]['number'].' عدد</td>
                                                <td>'.$result_1[$i]['product_price'].' تومان</td>
                                            </tr>
                                        ';
                                    }
                                    echo '
                                        </table>
                                    ';
                                }
                                else
                                {
                                    exit($sysMsg['serverError'][34]['msg34']);
                                }
                            }
                        ?>
                        <h5 id="type_of_product">خریدهای دانلودی:</h5>
                        <?php
                            $arguments_111 =
                                [
                                    'fields' => [],
                                    'values' => [$user_id],
                                    'query' => 'SELECT * FROM `payline` WHERE (`payline`.`status` > 0 AND `payline`.`user_id` = ?) ORDER BY `payline`.`id` DESC;'
                                ];
                            $result_111 = Model::run() -> c_find($arguments_111);
                            if ($result_111)
                            {
                                $sysMsg = jsonReader::reade('systemMessage.json');
                                if (count($result_111) > 0)
                                {
                                    echo '
                                        <table id="payline">
                                            <tr>
                                                <th>ردیف</th>
                                                <th>نام کالا</th>
                                                <th>قیمت</th>
                                                <th>کد رهگیری</th>
                                            </tr>
                                    ';
                                    for ($o = 0; $o < count($result_111); $o++)
                                    {
                                        echo '
                                            <tr>
                                                <td>'.($o + 1).'</td>
                                                <td>'.$result_111[$o]['product_name'].'</td>
                                                <td>'.$result_111[$o]['price'].' تومان</td>
                                                <td>'.$result_111[$o]['tracking_code'].'</td>
                                            </tr>
                                        ';
                                    }
                                    echo '
                                        </table>
                                    ';
                                }
                                else
                                {
                                    echo $sysMsg['serverError'][34]['msg34'];
                                }
                            }
                        ?>
                    </div>
                    <div id="my_basket" class="tab_content_inner <?php if (isset($_GET['b']) && $_GET['b'] === 'act') {echo 'show_content';}?>">
                            <?php
                                $all_price = 0;
                                $all_num = 0;
                                if (isset($result_all_purchases) && count($result_all_purchases) > 0)
                                {
                                    echo '
                                        <table>
                                            <tr>
                                                <th>ردیف</th>
                                                <th>عکس</th>
                                                <th>نام</th>
                                                <th>تعداد</th>
                                                <th>قیمت</th>
                                                <th>حذف</th>
                                            </tr>
                                        ';
                                    for ($i = 0; $i < count($result_all_purchases); $i++)
                                    {
                                        $all_price += intval($result_all_purchases[$i]['product_price']);
                                        $all_num += intval($result_all_purchases[$i]['number']);
                                        echo '
                                            <tr>
                                                <td>'.($i + 1).'</td>
                                                <td><img src="'._base_url.$result_all_purchases[$i]['product_pic'].'" alt=""></td>
                                                <td>'.$result_all_purchases[$i]['bought_product_name'].'</td>
                                                <td>'.$result_all_purchases[$i]['number'].' عدد</td>
                                                <td>'.$result_all_purchases[$i]['product_price'].' تومان</td>
                                                <td><a href="#?" data-id="'.$result_all_purchases[$i]['product_id'].'" class="delete_basket">حذف کالا</a></td>
                                            </tr>
                                         ';
                                    }
                                    if (count($result_all_purchases) > 0)
                                    {
                                        $dis_1 = 5000;
                                        $dis_2 = 10000;
                                        $dis_3 = 20000;
                                        $dis_4 = 30000;
                                        echo '
                                            </table>
                                            <table id="tbl_result">
                                                <tr>
                                                    <th>مجموع کالاها</th>
                                                    <th>مبلغ کل</th>
                                                    <th>مقدار تخفیف</th>
                                                    <th>مبلغ قابل پرداخت</th>
                                                    <th>ثبت نهایی و ادامه خرید</th>
                                                </tr>';

                                        echo '
                                                <tr>
                                                    <td>'.' '.$all_num.' '.'عدد</td>
                                                    <td>'.' '.$all_price.' '.'تومان</td>';

                                        if ( ($all_price - $dis_4) >= $dis_4)
                                        {
                                            $all_price = $all_price - $dis_4;
                                            echo '
                                                    <td>30%</td>
                                                    <td>'.' '.$all_price.' '.'تومان</td>
                                            ';
                                        }

                                        elseif (($all_price - $dis_3) >= $dis_3)
                                        {
                                            $all_price = $all_price - $dis_3;
                                            echo '
                                                    <td>20%</td>
                                                    <td>'.' '.$all_price.' '.'تومان</td>
                                            ';
                                        }

                                        elseif (($all_price - $dis_2) >= $dis_2)
                                        {
                                            $all_price = $all_price - $dis_2;
                                            echo '
                                                    <td>10%</td>
                                                    <td>'.' '.$all_price.' '.'تومان</td>
                                            ';
                                        }

                                        elseif (($all_price - $dis_1) >= $dis_1)
                                        {
                                            $all_price = $all_price - $dis_1;
                                            echo '
                                                    <td>5%</td>
                                                    <td>'.' '.$all_price.' '.'تومان</td>
                                            ';
                                        }

                                        else
                                        {
                                            echo '
                                                    <td>0%</td>
                                                    <td>'.' '.$all_price.' '.'تومان</td>
                                            ';
                                        }

                                    echo '
                                                    <td><a href="'._base_url.'sign_purchase.php" id="pay">ثبت نهایی</a></td>
                                                </tr>
                                            </table>
                                        ';
                                    }
                                }
                                else
                                {
                                    $sysMsg = jsonReader::reade('systemMessage.json');
                                    echo $sysMsg['serverError'][24]['msg24'];
                                }
                            ?>
                    </div>
                    <div id="my_profile" class="tab_content_inner <?php if (!isset($_GET['b'])) {echo 'show_content';}?>">
                        <table id="profile">
                            <tr>
                                <th>نام و نام خانوادگی</th>
                                <th>ایمیل</th>
                                <th>تلفن همراه</th>
                                <th>تلفن ثابت</th>
                                <th>شماره تماس اضطراری</th>
                                <th>کد پستی</th>
                                <th>آدرس</th>
                            </tr>
                            <?php
                                $arguments_2 =
                                    [
                                        'fields' => [],
                                        'values' => [$user_id],
                                        'query' => 'SELECT * FROM `users` WHERE (`users`.`id`  = ?);'
                                    ];
                                $result_2 = Model::run() -> c_find($arguments_2);
                                if ($result_2)
                                {
                                    for ($k = 0; $k < count($result_2); $k++)
                                    {
                                        echo '
                                             <tr>
                                                <td>'.$result_2[$k]['name'].' ' .$result_2[$k]['lastName'].'</td>
                                                <td>'.$result_2[$k]['email'].'</td>
                                                <td>'.$result_2[$k]['cellphone'].'</td>
                                                <td>'.$result_2[$k]['landline_phone'].'</td>
                                                <td>'.$result_2[$k]['necessary_phone'].'</td>
                                                <td>'.$result_2[$k]['postal_code'].'</td>
                                                <td>'.$result_2[$k]['address'].'</td>
                                            </tr>
                                        ';
                                    }
                                }
                            ?>
                        </table>
                        <span href="" id="update_profile">تغییر مشخصات</span>
                        <div id="change_profile_inner">
                            <div id="result_update">
                                <?php
                                    if (isset($_POST['update_profile']))
                                    {
                                        $sysMsg = jsonReader::reade('systemMessage.json');
                                        $_POST = array_slice($_POST, 0, count($_POST) - 1);
                                        $_POST['user_id'] = $user_id;
                                        echo $result_update_profile = call_user_func_array('check_user_update_profile', array($_POST));
                                    }
                                ?>
                            </div>
                            <?php
                                if (isset($result_2))
                                {
                                    for ($k = 0; $k < count($result_2); $k++)
                                    {
                                        echo '
                                            <form action="" method="post">
                                                <label for="">نام</label><input type="text" name="name" value="'.$result_2[$k]['name'].'">
                                                <label for="">نام خانوادگی</label><input type="text" name="lastname" value="'.$result_2[$k]['lastName'].'">
                                                <label for="">ایمیل</label><input type="text" name="email" value="'.$result_2[$k]['email'].'">
                                                <label for="">شماره همراه</label><input type="text" name="cellphone" value="'.$result_2[$k]['cellphone'].'">
                                                <label for="">تلفن ثابت</label><input type="text" name="landline_phone" value="'.$result_2[$k]['landline_phone'].'">
                                                <label for="">شمراه تماس ضروری</label><input type="text" name="necessary_phone" value="'.$result_2[$k]['necessary_phone'].'">
                                                <label for="">کد پستی</label><input type="text" name="postal_code" value="'.$result_2[$k]['postal_code'].'">
                                                <label for="">آدرس</label><textarea name="address" id="" cols="70" rows="10">'.$result_2[$k]['address'].'</textarea>
                                                <input type="submit" name="update_profile" value="ثبت مشخصات">
                                                <input type="reset" id="cancel_update" value="انصراف">
                                            </form>
                                        ';
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= _base_url_2; ?>assets/lib/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= _base_url_2; ?>assets/lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= _base_url_2; ?>assets/script/script_7.js"></script>
<script type="text/javascript" language="JavaScript">
    var logout = get._id('logout');
    logout.addEventListener('click', function ()
    {
        var msg = confirm('از حساب خود خارج می شوید؟');
        if (msg === true)
        {
            window.location.href = baseURL + 'user_logout.php';
        }
        else
        {
            window.location.href = '#?';
        }
    });
</script>

<script type="text/javascript" language="JavaScript">
    var deleteBasket = get._class('delete_basket');
    for (var i = 0; i < deleteBasket.length; i++)
    {
        deleteBasket[i].addEventListener('click', function (e)
        {
            e.preventDefault();
            var stuff_id = this.getAttribute('data-id');
            var del_msg = confirm('آیا از حذف این کالا مطمئن هستید؟');
            if (del_msg === true)
            {
                window.location = baseURL + 'delete_basket.php?pi=' + stuff_id;
            }
            else
            {
                window.location.href = '#?';
                return false;
            }
        });
    }
</script>

<script type="text/javascript" language="JavaScript">
    var update_profile, cancel_update;
    update_profile= get._id('update_profile');
    cancel_update = get._id('cancel_update');

    update_profile.addEventListener('click', function ()
    {
        var box = get._id('change_profile_inner');
        box.classList.add('show_update')
    });

    cancel_update.addEventListener('click', function ()
    {
        var box = get._id('change_profile_inner');
        box.classList.remove('show_update');
    });

</script>
</body>
</html>
<?php
