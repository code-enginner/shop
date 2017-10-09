<?php
    require_once '../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';

//    session_unset();
//    session_destroy();

    // redirect admin to panel page if already logged in
    if (is_login())
    {
        header('Location:'._base_url.'panel.php');
        exit();
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
    <link rel="stylesheet" type="text/css" href="<?= _base_url_2; ?>assets/style/_admin_login.css">
    <title>Document</title>
</head>
<body dir="rtl">
<div id="admin_content" class="container-fluid">
    <div class="row">

        <div id="login_form" class="col-lg-6 col-md-8 col-sm-8 col-xs-12">
            <h4 id="admin_login_header" class="unSelect">ورود مدیر<i class="fa fa-unlock-alt" aria-hidden="true"></i></h4>

            <div id="admin_login_content" class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right">
                <form action="" method="post">
                    <label for="">نام کاربری</label><input type="text" name="username" placeholder="نام کاربری یا ایمیل..." value="<?php if (isset($_POST['username'])){echo $_POST['username'];} ?>" id="username" class="">
                    <div class="hint"><p></p></div>
                    <label for="">رمز عبور</label><input type="password" name="password" placeholder="رمز عبور..." id="password" class="">
                    <div class="hint"><p></p></div>
                    <label for="">تصویر امنیتی</label><input type="text" name="secureCode" placeholder="تصویر امنیتی..." id="secureCode" class="">
                    <div class="hint"><p></p></div>
                    <input type="submit" name="submit" value="ورود" id="" class="unSelect">
                    <input type="reset" name="reset" value="پاک کردن" id="" class="unSelect">
                </form>
            </div>
            <div id="captcha_content" class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-left">
                captcha
            </div>
            <div class="clear-fix"></div>

        </div>
        <div class="hint"><p></p></div>
    </div>
</div>

<script type="text/javascript" src="<?= _base_url_2; ?>assets/lib/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= _base_url_2; ?>assets/lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= _base_url_2; ?>assets/script/script.js"></script>
</body>
</html>
<?php

    use configReader\jsonReader;
    use functions\Model;
    //todo: create javascript function to blur checking
    //todo: create a function to handle all login: `admin & users`

    function validateInputs(array $data)
    {
        $sysMsg = jsonReader::reade('systemMessage.json');      // getting the content of system message file
        $elm = [];
        foreach ($data as $key => $value)
        {
            if ($data[$key] === '' || $data[$key] === NULL)
            {
                $elm[] = $key;      // getting the name of any input if it is empty
            }
        }
        for ($i = 0; $i < count($elm); $i++)
        {
            // create error message for any input that was empty
            switch ($elm[$i])
            {
                case 'username':
                    return $sysMsg['userError'][0]['msg0'];
                    break;
                case 'password':
                    return $sysMsg['userError'][1]['msg1'];
                    break;
                case 'secureCode':
                    return $sysMsg['userError'][2]['msg2'];
                    break;
            }
        }
        if (count($elm) > 0)
        {
            return array
            (
                FALSE,
                $elm
            );
        }
        else
        {
            foreach ($data as $key => $value)
            {
                $data[$key] = htmlspecialchars($value);     // safe the user input values
            }
            $arguments =
                [
                    'data' => $data,
                    'tableName' => 'admin',
                    'mathOp' => ['='],
                    'logicOp' => ['and'],
                    'fetchAll' => FALSE
                ];

            $is_admin = Model::run() -> find($arguments);
            if ($is_admin === FALSE)
            {
                return $sysMsg['serverError'][2]['msg2'];
            }
            elseif($is_admin !== FALSE && !is_array($is_admin))
            {
                return $is_admin;
            }
            else
            {
                return array
                (
                    TRUE,
                    $is_admin
                );
            }
        }
    }

    if (isset($_POST['submit']))
    {
        $sysMsg = jsonReader::reade('systemMessage.json');
        //todo: add captcha code to validate
        $userInputs = array_slice($_POST, 0, count($_POST) - 2);
        $result = call_user_func_array('validateInputs', array($userInputs));
        if (isset($result[0]) && $result[0] === TRUE)
        {
            if (isset($result[1][0]['lName']) && isset($result[1][0]['fName']) && isset($result[1][0]['email']))
            {
                $_SESSION['lName'] = $result[1][0]['lName'];
                $_SESSION['fName'] = $result[1][0]['fName'];
                $_SESSION['email'] = $result[1][0]['email'];
                header('Location:'._base_url.'panel.php');
                exit();
            }
            else
            {
                $_SESSION['lName'] = '';
                $_SESSION['fName'] = '';
                $_SESSION['email'] = '';
                unset($_SESSION['lName']);
                unset($_SESSION['fName']);
                unset($_SESSION['email']);
                header('Location:'._base_url.'login.php');
                exit();
            }
        }
        else
        {
            $_SESSION['lName'] = '';
            $_SESSION['fName'] = '';
            $_SESSION['email'] = '';
            unset($_SESSION['lName']);
            unset($_SESSION['fName']);
            unset($_SESSION['email']);
            echo $result;
        }
    }