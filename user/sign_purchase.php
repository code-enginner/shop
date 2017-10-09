<?php

    use configReader\jsonReader;
    use functions\Model;

    require_once '../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';
    require_once root.'user/check_sign_purchase.php';
    require_once root.'functions/jdf.php';

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
    <link rel="stylesheet" type="text/css" href="<?= _base_url_2; ?>assets/style/_sign_purchase.css">
    <script type="text/javascript" src="<?= _base_url_2; ?>assets/script/myClass.js"></script>
    <script type="text/javascript" language="JavaScript"> var baseURL = "<?= _base_url; ?>"; </script>
    <title>ثبت خرید</title>
</head>
<body dir="rtl">
<?php

?>

<div class="container-fluid">
    <div class="row">
        <div class="form">
            <div class="pay_hint">
                <h5>توجه</h5>
                <p>چناچه قصد دارید با اطلاعات دیگری غیر از آنچه در زمان ثبت نام وارد کرده اید اقدام به خرید کالا کنید فیلدهای بدون ستاره را به دقت پر کنید، زیرا فاکتور فروش و کد رهگیری به آدرس ایمیل و شماره همراه جدید ارسال می شود همچنین با تغییر آدرس و کد پستی، مرسوله نیز به آدرس جدید ارسال می شود.در ضمن می توانید در فیلد مربوط به " توضیحات اضافه " اطلاعات سودمندی که پروسه و زمان ارسال کالا را کمتر می کند، ذکر کنید. <i class="hint_2">(فیلدهای ستاره دار،  ضروری هستند.)</i></p>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php
                    if (isset($_POST['pay']))
                    {
                        $_POST = array_slice($_POST, 0, count($_POST) - 1);
                        $sysMsg = jsonReader::reade('systemMessage.json');
                        $result_pay = call_user_func_array('check_user_sign_purchase', array($_POST));
                        if (isset($result_pay[1]) && $result_pay[1] === TRUE)
                        {
                            echo '<div class="alert alert-success success"><h5><i class="fa fa-window-close"></i><i class="break_line"></i>کد رهگیری شما: '.$result_pay[0].'</h5></div>';
                        }
                        else
                        {
                            echo $result_pay;
                        }

                    }
                ?>
            </div>
            <form action="" method="post">
                <label for="">نام و نام خانوادگی<i class="fa fa-asterisk" aria-hidden="true"></i></label><input type="text" id="" name="full_name" placeholder="نام و نام خانوادگی">
                <label for="">شماره تلفن همراه <i class="new">(جدید)</i></label><input type="text" id="" name="user_new_phone" placeholder="شماره تلفن همراه جدید" maxlength="11">
                <label for="">ایمیل <i class="new">(جدید)</i></label><input type="email" id="" name="user_new_email" placeholder="ایمیل جدید">
                <label for="">نوع سفارش<i class="fa fa-asterisk" aria-hidden="true"></i></label>
                <select name="order_type" id="">
                    <option value="">نوع سفارش خود را انتخاب کنید</option>
                    <option value="" disabled></option>
                    <option value="normal">معمولی</option>
                    <option value="leading">پیشتاز</option>
                    <option value="express">اکسپرس</option>
                </select>
                <label for="">کد پستی <i class="new">(جدید)</i></label><input type="text" id="" name="user_new_postal_code" placeholder="کد پستی جدید">
                <label for="">آدرس <i class="new">(جدید)</i></label>
                <textarea name="user_new_address" id="" cols="100" rows="10" placeholder="در صورت نیاز می توانید آدرس جدیدی وارد کنید.  "></textarea>
                <label for="">توضیحات اضافه</label>
                <textarea name="user_points" id="" cols="100" rows="10" placeholder="در صورت نیاز می توانید توضیحات ضروری را وارد کنید.  "></textarea>
                <input type="submit" name="pay" value="پرداخت">
                <input type="reset" value="انصراف" id="pay_cancel">
            </form>
        </div>
    </div>
</div>




<script type="text/javascript" src="<?= _base_url_2; ?>assets/lib/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= _base_url_2; ?>assets/lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" language="JavaScript">
    var cancel = get._id('pay_cancel');
    console.log(baseURL + 'userPanel.php');
    cancel.addEventListener('click', function ()
    {
        window.location.href = baseURL + 'userPanel.php?ui=' + <?= $_SESSION['user_id']?>;
    });
</script>
</body>
</html>
