<?php
    use configReader\jsonReader;
//    unset($_SESSION['captcha']);
?>
<div id="first_wrapper" class="unSelect col-lg-12 col-md-12 col-sm-12 col-xs-12 clear_fix">
    <ul class="first_top_level_menu clear_fix">
        <li><span class="time"><i class="fa fa-clock-o" aria-hidden="true"></i><?= jdate('l  j  F  Y'); ?></span></li>
        <li>
            <?php
                if (!isset($_SESSION['user_id']))
                {
                    echo '
                                <a href="#" id="user_login"><i class="fa fa-sign-in" aria-hidden="true"></i>سلام، به حساب کاربری خود وارد شوید</a>
                            ';
                }
                else
                {
                    if (isset($_GET['fl']) && $_GET['fl'] == '1')
                    {
                        echo '
                                <span class="user_welcome"><i class="fa fa-address-card" aria-hidden="true"></i> سلام <i class="user_info">'.$_SESSION['user_name'].'</i> عزیز، خوش آمدی</span>
                                <span class="go_panel"><a href="'._base_url.'user/userPanel.php?ui='.$_SESSION['user_id'].'"><i class="fa fa-newspaper-o" aria-hidden="true"></i>برو به پنل کاربری من</a></span>
                            ';
                    }
                    else
                    {
                        if ($_SESSION['user_logged_date'] == 0)
                        {
                            echo '
                                <span class="user_welcome"><i class="fa fa-address-card" aria-hidden="true"></i> سلام <i class="user_info">'.$_SESSION['user_name'].'</i> عزیز، خوش آمدی</span>
                                <span class="user_welcome"><i class="" aria-hidden="true"></i> این <i class="user_info">اولین</i> ورود شما به سایت است</span>
                                <span class="go_panel"><a href="'._base_url.'user/userPanel.php?ui='.$_SESSION['user_id'].'"><i class="fa fa-newspaper-o" aria-hidden="true"></i>برو به پنل کاربری من</a></span>
                            ';
                        }
                        else
                        {
                            echo '
                                <span class="user_welcome"><i class="fa fa-address-card" aria-hidden="true"></i> سلام <i class="user_info">'.$_SESSION['user_name'].'</i> عزیز، خوش آمدی</span>
                                <span class="user_welcome"><i class="fa fa-calendar" aria-hidden="true"></i> زمان آخرین ورود شما : <i class="user_info">'.jdate('l  j  F  Y, در ساعت  s : i : H', $_SESSION['user_logged_date']).'</i></span>
                                <span class="go_panel"><a href="'._base_url.'user/userPanel.php?ui='.$_SESSION['user_id'].'"><i class="fa fa-newspaper-o" aria-hidden="true"></i>برو به پنل کاربری من</a></span>
                            ';
                        }
                    }

                }
            ?>
            <div id="login_modal" class="fillBack <?php if (isset($_POST['login'])) {echo 'fillBack_active';}?>">
                <i class="modal_close fa fa-window-close fa-2x" aria-hidden="true"></i>
                <div id="login_wrapper" class="clear_fix">
                    <div id="login_content" class="clear_fix">
                        <?php
                            if (isset($_POST['login']))
                            {
                                $sysMsg = jsonReader::reade('systemMessage.json');
                                $_POST = array_slice($_POST, 0, count($_POST) - 1);
                                $result_login = call_user_func_array('login_validation', array($_POST));
                            }
                        ?>
                        <form action="" method="post" class="clear_fix">
                            <div class="list_option col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-right">
                                <ul>
                                    <li><label for="">ایمیل<i class="fa fa-asterisk" aria-hidden="true"></i></label><input type="email" id="" name="email" placeholder="ایمیل خود را وارد کنید"></li>
                                    <li><label for="">رمز عبور<i class="fa fa-asterisk" aria-hidden="true"></i></label><input type="text" id="" name="password" placeholder="رمز عبور را وارد کنید"></li>
                                    <li><label for="">کد امنیتی <i id="des">(حساس به حروف بزرگ و کوچک)</i><i class="fa fa-asterisk" aria-hidden="true"></i></label><input type="text" id="" name="secure_code" placeholder="کد امنیتی مقابل را وارد کنید"></li>
                                </ul>
                            </div>
                            <div class="captcha_wrapper col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-left">
                                <div class="captcha_content_one clear_fix">
                                    <img src="<?= _base_url; ?>functions/Captcha.php" alt="" width="" height="">

<!--                                    <div class="captcha_reload pull-left"><i class="fa fa-refresh" aria-hidden="true"></i></div>-->
                                </div>
                            </div>
                            <div class="list_option_two col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <ul>
                                    <li><input type="submit" name="login" value="ورود"><input id="cancel_login" type="reset" value="انصراف"></li>
                                </ul>
                            </div>
                        </form>
                        <p id="forget_password"><a href="<?= _base_url; ?>user/forget_password.php"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>رمز عبور خود را فراموش کرده ام! </a></p>
                    </div>
                </div>
            </div>

        </li>
        <li>
            <?php
                if (!isset($_SESSION['user_id']))
                {
                    echo '
                                <a href="#?" id="register" data-modal-hide="true"><i class="fa fa-user-plus" aria-hidden="true"></i>ثبت نام کنید</a>
                            ';
                }
            ?>
            <div id="modal" class="fillBack <?php if ((isset($_GET['setback']) && $_GET['setback'] == 1) || isset($_POST['user_register'])) { echo 'fillBack_active';} ?>">
                <i class="modal_close fa fa-window-close fa-2x" aria-hidden="true"></i>
                <div id="content_wrapper" class="clear_fix">
                    <div id="modal_content" class="clear_fix">
                        <?php
                            if (isset($_POST['user_register']))
                            {
                                $sysMsg = jsonReader::reade('systemMessage.json');
                                $register_time = time();
//                                        dump(date('Y : m : d / '.'H : i : s A'));
                                $_POST = array_slice($_POST, 0, count($_POST) - 1);
                                $_POST['register_time'] = $register_time;
                                $user_register_result = call_user_func_array('check_user_input_register', array($_POST));
                                if ($user_register_result === TRUE)
                                {
                                    echo $sysMsg['serverSuccess'][7]['msg7'];
                                }
                                else
                                {
                                    echo $user_register_result;
                                }
                            }
                        ?>
                        <form action="" method="post" class="clear_fix">
                            <div class="list_one col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-right">
                                <ul class="clear_fix">
                                    <li><label for="">نام<i class="fa fa-asterisk" aria-hidden="true"></i></label><input type="text" id="" name="user_name" placeholder="نام" class="user_fields" value="<?php if (isset($_POST['user_name'])) {echo $_POST['user_name'];}?>"></li>
                                    <li><label for=""><i></i>نام خانوادگی<i class="fa fa-asterisk" aria-hidden="true"></i></label><input type="text" id="" name="user_family" class="user_fields" placeholder="نام خانوادگی" value="<?php if (isset($_POST['user_family'])) {echo $_POST['user_family'];}?>"></li>
                                    <li><label for=""><i></i>پست الکترونیک<i class="fa fa-asterisk" aria-hidden="true"></i></label><input type="email" id="" name="user_email" class="user_fields" placeholder="ایمیل" value="<?php if (isset($_POST['user_email'])) {echo $_POST['user_email'];}?>"></li>
                                    <li><label for="">رمز عبور<i class="fa fa-asterisk" aria-hidden="true"></i></label><input type="password" id="" name="user_password" class="user_fields" placeholder="رمز عبور"></li>
                                    <li><label for="">تکرار رمز عبور<i class="fa fa-asterisk" aria-hidden="true"></i></label><input type="password" id="" name="R_user_password" class="user_fields" placeholder="تکرار رمز عبور"></li>
                                    <li><label for="">شماره تلفن همراه<i class="fa fa-asterisk" aria-hidden="true"></i></label><input type="text" id="" name="user_cellphone" class="user_fields" placeholder="شماره تلفن همراه" maxlength="11" value="<?php if (isset($_POST['user_cellphone'])) {echo $_POST['user_cellphone'];}?>"><span class="error_hint"></span></li>
                                </ul>
                            </div>
                            <div class="list_two col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-left">
                                <ul>
                                    <li><label for="">شماره تلفن ثابت<i class="fa fa-asterisk" aria-hidden="true"></i></label><input type="text" id="" name="user_landline_phone" class="user_fields" placeholder="شماره تلفن ثابت را به همراه کد شهری وارد کنید" maxlength="11" value="<?php if (isset($_POST['user_landline_phone'])) {echo $_POST['user_landline_phone'];}?>"><span class="error_hint"></span></li>
                                    <li><label for="">شماره تماس ضروری(شماره همراه)<i class="fa fa-asterisk" aria-hidden="true"></i></label><input type="text" id="" name="user_necessary_phone" class="user_fields" placeholder="شماره تلفن همراه جهت تماس ضروری" maxlength="11" value="<?php if (isset($_POST['user_necessary_phone'])) {echo $_POST['user_necessary_phone'];}?>"><span class="error_hint"></span></li>
                                    <li><label for="">کد پستی<i class="fa fa-asterisk" aria-hidden="true"></i></label><input type="text" id="" name="user_postal_code" class="user_fields" placeholder="کد پستی" maxlength="20" value="<?php if (isset($_POST['user_postal_code'])) {echo $_POST['user_postal_code'];}?>"><span class="error_hint"></span></li>
                                    <li><label for="">آدرس پستی دقیق<i class="fa fa-asterisk" aria-hidden="true"></i></label><textarea name="user_address" id="" cols="54" rows="5" class="user_fields" placeholder="آدرس پستی دقیق"><?php if (isset($_POST['user_address'])) {echo $_POST['user_address'];}?></textarea><span class="error_hint"></span></li>
                                </ul>
                            </div>
                            <br>
                            <br>
                            <div class="list_two col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <ul>
                                    <li>
                                        <div id="captcha_wrapper">
                                            <div class="captcha_content ">
                                                <img src="<?= _base_url; ?>functions/Captcha_2.php" alt="" width="" height="">
<!--                                                <div class="captcha_controller col-lg-1 col-md-1 col-sm-1 col-xs-1 pull-left"><i class="fa fa-refresh" aria-hidden="true"></i></div>-->
                                                <div class="img_content">

                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li><label for="">کد امنیتی <i id="des">(حساس به حروف بزرگ و کوچک)</i><i class="fa fa-asterisk" aria-hidden="true"></i></label><input type="text" id="secure_code" name="secure_code"  class="user_fields" placeholder="کد امنیتی بالا را وارد کنید" maxlength="7"><span class="error_hint"></span></li>
                                </ul>
                            </div>
                            <div class="list_two col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <ul>
                                    <li><input type="submit" name="user_register" id="registering" value="ثبت نام"><input type="reset" id="f" name="" value="انصراف"></li>
                                    <li></li>
                                </ul>
                            </div>
                        </form>
                    </div><!--/ #modal_content-->
                </div><!-- /# content_wrapper-->
            </div>
        </li>
    </ul>
</div>