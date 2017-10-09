<?php

    use configReader\jsonReader;
    use functions\Model;

    require_once '../../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';
    require_once root.'admin/admin_manage_account/check_update_admin.php';
    if (!is_login())
    {
        header('Location:'._base_url.'login.php');
        exit();
    }
?>
<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="<?= _base_url_3; ?>assets/lib/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?= _base_url_3; ?>assets/lib/bootstrap-3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?= _base_url_3; ?>assets/style/_font.css">
    <link rel="stylesheet" type="text/css" href="<?= _base_url_3; ?>assets/style/_reset.css">
    <link rel="stylesheet" type="text/css" href="<?= _base_url_3; ?>assets/style/_manage_account.css">
    <script type="text/javascript" src="<?= _base_url_3; ?>assets/script/myClass.js"></script>
    <script type="text/javascript"> var baseURL = "<?= _base_url; ?>"</script>
    <title>Document</title>
</head>
<body dir="rtl">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h5 id="insert_header">درج مشخصات</h5>
            <?php
                if (!isset($_GET['id']))
                {
                    header('Location:'._base_url.'manage-admin.php');
                    exit();
                }
                else
                {
                    $id = htmlspecialchars(intval($_GET['id']));
                    $data =
                        [
                            'fields' => [],
                            'values' => [$id],
                            'query' => 'SELECT * FROM `admin`  WHERE (`admin`.`id` = ?);'
                        ];
                    $result = Model::run() -> c_find($data);
                    if ($result)
                    {
                        for ($i = 0; $i < count($result); $i++)
                        {
                            echo '
                                <form action="" method="POST">
                                    <label for="">نام<i class="fa fa-asterisk"></i></label><input type="text" name="name" placeholder="نام" value="'.$result[$i]['fName'].'">
                                    <label for="">نام خانوادگی<i class="fa fa-asterisk"></i></label><input type="text" name="lastname" placeholder="نام خانوادگی" value="'.$result[$i]['lName'].'">
                                    <label for="">ایمیل<i class="fa fa-asterisk"></i></label><input type="email" name="email" placeholder="ایمیل" value="'.$result[$i]['email'].'">
                                    <label for="">نام کاربری<i class="fa fa-asterisk"></i></label><input type="text" name="username" placeholder="نام کاربری" value="'.$result[$i]['username'].'">
                                    <label for="">رمز عبور<i class="fa fa-asterisk"></i></label><input type="password" name="password" placeholder="رمز عبور" value="'.$result[$i]['password'].'">
                                    <input type="submit" name="register_admin" value="ثبت مشخصات">
                                    <input type="reset" id="back" value="انصراف">
                                </form>
                            ';
                        }
                    }
                }
            ?>

        </div>
        <div class="result col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php
                if (isset($_POST['register_admin']))
                {
                    $_POST = array_slice($_POST, 0,count($_POST) - 1);
                    call_user_func_array('check_update_values', array($_POST));
                }
            ?>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?= _base_url_3; ?>assets/lib/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= _base_url_3; ?>assets/lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" language="JavaScript">
    var back = get._id('back');
    back.addEventListener('click', function ()
    {
        window.location.href = baseURL + "manage_account.php";
    });
</script>
</body>
</html>
<?php
