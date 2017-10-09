<?php

    use configReader\jsonReader;
    use functions\Model;

    require_once '../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';
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
    <link rel="stylesheet" type="text/css" href="<?= _base_url_2; ?>assets/style/_forget_password.css">
    <script type="text/javascript" src="<?= _base_url_2; ?>assets/script/myClass.js"></script>
    <script type="text/javascript" language="JavaScript"> var baseURL = "<?= _base_url_2; ?>"</script>
    <title>Document</title>
</head>
<body dir="rtl">

<div class="container-fluid">
    <div class="row">
        <div class="content">
            <div id="description" class="unSelect">
                <span>راهنما:</span>
                <p>کاربر گرامی لطفا ایمیل خود را وارد کنید و دکمه " ارسال کد شناسایی " را بزنید. ما؛ برای شما یک کد شناسایی با مدت اعتباری 24 ساعت، به آدرس ایمیلی که وارد کرده اید ارسال می کنیم.کد شناسایی را در کادر مربوطه وارد کرده و بعد، با فشردن دکمه " ایجاد رمز جدید " در صورت معتبر بودن کد شناسایی کادر جدیدی باز می شود که می توانید از طریق آن رمز عبور جدیدی برای خود ایجاد کنید.<br>(کد شناسایی، به حروف بزرگ و کوچک حساس است)</p>
                <span id="reminder">تذکر:</span>
                <p id="hint">در هر بار تغییر رمز، شما فقط یک مرتبه فرصت دارید تا رمز عبور خود را تغییر دهید.اگر کادر را خالی ارسال کنید یا رمز جدید خود را با دقت کافی وارد نکنید باید دوباره کد شناسایی جدید دریافت کنید.</p>
                <span> لطفا در حفظ و نگهداری رمز عبور خود کوشا باشید!</span>
            </div>
            <div class="form col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right">
                <form action="" method="post">
                    <ul>
                        <li>
                            <label class="unSelect" for="">ایمیل<i class="fa fa-asterisk" aria-hidden="true"></i></label><input type="email" id="" name="email" placeholder="ایمیل خود را وارد کنید">
                        </li>
                        <li><input class="unSelect" type="submit" name="send_pass" value="ارسال کد شناسایی"><input id="cancel_forget_password" class="unSelect" type="reset" value="انصراف"></li>
                    </ul>
                </form>
            </div>
            <div class="form col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right">
                <form action="" method="post">
                    <ul>
                        <li>
                            <label class="unSelect" for="">کد شناسایی<i class="fa fa-asterisk" aria-hidden="true"></i></label><input type="text" id="" name="email" placeholder="کد شناسایی را وارد کنید">
                        </li>
                        <li><input class="unSelect" type="submit" name="check_temp_code" value="ایجاد رمز جدید"></li>
                    </ul>
                </form>
            </div>
        </div>

        <div class="show_result col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php

                function handle($argument)
                {
                    $sysMSG = jsonReader::reade('systemMessage.json');
                    $user_email = NULL;
                    $token = NULL;
                    $elm = [];
                    $values = [];
                    $request_time = NULL;
                    foreach ($argument as $key => $value)
                    {
                        switch ($key)
                        {
                            case 'email':
                                if ($argument[$key] === '' || $argument[$key] === NULL)
                                {
                                    $elm[] = 'ایمیل';
                                }
                                else
                                {
                                    $user_email = $argument[$key];
                                }
                                break;
                        }
                    }

                    if (count($elm) > 0)
                    {
                        return $sysMSG['serverError'][5]['msg5'];
                    }
                    else
                    {
                            $data_1 =
                            [
                                'fields' => [],
                                'values' => [$user_email],
                                'query' => 'SELECT `id`, `name`, `lastName` FROM `users` WHERE `email` = ? LIMIT 1;'
                            ];
                        $result_1 =  Model::run() -> c_find($data_1);
                        if (count($result_1) === 0)
                        {
                            $msg =  $sysMSG['serverError'][20]['msg20'];
                            $msg .= '<div id="first_register" class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><a href="'._base_url_2.'index.php?setback=1" id="register" data-modal-hide="true"><i class="fa fa-user-plus" aria-hidden="true"></i>ثبت نام می کنم</a></div>';
                            return $msg;
                        }
                        else
                        {
                            $user_name = $result_1[0]['name'].' '.$result_1[0]['lastName'];
                            $str = '0123456789aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsSuUvVwWxXyYzZ';
                            $temp_password = NULL;
                            for ($i = 0; $i < 10; $i++)
                            {
                                $temp_password .= substr($str, random_int(0, strlen($str) - 1), 1);
                            }

                            $values[] = NULL;
                            $values[] = $result_1[0]['id'];
                            $values[] = $temp_password;
                            $values[] = time();
                            $values[] = md5(time().microtime().'!354 Io.+{');

                            $data_2 =
                                [
                                    'fields' => [],
                                    'values' => $values,
                                    'query' => 'INSERT INTO `forget_password` VALUES (?, ?, ?, ?, ?);'
                                ];
                            $result_2 =  Model::run() -> c_find($data_2);
                            if ($result_2)
                            {
                                echo '
                                    <div class="alert alert-success success"><h5><i class="fa fa-window-close"></i><i class="break_line"></i>'.$user_name.' عزیز کد شناسایی به آدرس ایملیتان ارسال شد.</h5></div>
                                ';
                                echo $temp_password;
                            }
                            else
                            {
                                echo 'false';
                            }
                        }
                    }
                }


                if (isset($_POST['send_pass']))
                {
                    $_POST = array_slice($_POST, 0, count($_POST) - 1);
                    $result = call_user_func_array('handle', array($_POST));
                    echo $result;
                }


                if (isset($_POST['check_temp_code']))
                {
                    $sysMSG = jsonReader::reade('systemMessage.json');
                    $values = [];
                    $_POST = array_slice($_POST, 0, count($_POST) - 1);

                    $values[] = htmlspecialchars($_POST['email']);
                    $user_interred_temp_code = htmlspecialchars($_POST['email']);

                    $data_3 =
                        [
                            'fields' => [],
                            'values' => $values,
                            'query' => 'SELECT * FROM `forget_password` WHERE `temp_password` = ?;'
                        ];
                    $result_3 =  Model::run() -> c_find($data_3);

                    if ($result_3 && count($result_3) > 0)
                    {
                        $send_time = $result_3[0]['request_time'];
                        $user_id = $result_3[0]['user_id'];
                        $_SESSION['user_id'] = $result_3[0]['user_id'];
                        if ($user_interred_temp_code !== $result_3[0]['temp_password'])
                        {
                            return $sysMSG['serverError'][21]['msg21'];
                        }

                        if ((time() - $send_time) > 86400)
                        {
                            echo $sysMSG['serverError'][22]['msg22'];

                            $data_4 =
                                [
                                    'fields' => [],
                                    'values' => [$user_id],
                                    'query' => 'DELETE FROM `forget_password` WHERE `user_id` = ?;'
                                ];
                            Model::run() -> c_find($data_4);
                            return FALSE;
                        }
                        else
                        {
                            echo '
                                <hr>
                                <div id="sent_new_password" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                     <form action="" method="post">
                                        <ul>
                                            <li>
                                                <label class="unSelect" for="">رمز عبور جدید<i class="fa fa-asterisk" aria-hidden="true"></i></label><input type="text" id="" name="new_password" placeholder="رمز عبور جدید را وارد کنید">
                                                <input type="hidden" name="user_id_change_pass_request" value="'.$user_id.'">
                                            </li>
                                            <li><input class="unSelect" type="submit" name="change_password" value="تغییر رمز"></li>
                                        </ul>
                                     </form>                               
                                </div>
                            ';
                        }
                    }
                }

                if (isset($_POST['change_password']))
                {
                    $sysMSG = jsonReader::reade('systemMessage.json');
                    if (!isset($_SESSION['user_id']))
                    {
                        exit();
                    }
                    else
                    {
                        if (!isset($_POST['new_password']) || $_POST['new_password'] === '' || $_POST['new_password'] === NULL)
                        {
                            echo $sysMSG['serverError'][33]['msg33'];
                            exit();
                        }
                        else
                        {
                            $_POST = array_slice($_POST, 0, count($_POST) - 1);
                            $values  = [];
                            $values[] = htmlspecialchars($_POST['new_password']);
                            $values[] = $_SESSION['user_id'];

                            $data_5 =
                                [
                                    'fields' => [],
                                    'values' => $values,
                                    'query' => 'UPDATE `users` SET `password` = ? WHERE `id` = ?;'
                                ];
                            $result_5 = Model::run() -> c_find($data_5);

                            if ($result_5)
                            {
                                echo $sysMSG['serverSuccess'][8]['msg8'];
                                $data_6 =
                                    [
                                        'fields' => [],
                                        'values' => [$_SESSION['user_id']],
                                        'query' => 'DELETE FROM `forget_password` WHERE `user_id` = ?;'
                                    ];
                                $result_6 = Model::run() -> c_find($data_6);
                                if ($data_6)
                                {
                                    unset($_SESSION['user_id']);
                                }
                                return TRUE;
                            }
                        }
                    }
                }
            ?>
        </div>
    </div>
</div>







<script type="text/javascript" src="<?= _base_url_2; ?>assets/lib/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= _base_url_2; ?>assets/lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= _base_url_2; ?>assets/script/script_5.js"></script>
</body>
</html>
<?php
