<?php

    use configReader\jsonReader;
    use functions\Model;

    require_once '../../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';
    require_once root.'admin/admin_manage_account/check_admin_registration.php';
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
            <form action="" method="POST">
                <label for="">نام<i class="fa fa-asterisk"></i></label><input type="text" name="name" placeholder="نام">
                <label for="">نام خانوادگی<i class="fa fa-asterisk"></i></label><input type="text" name="lastname" placeholder="نام خانوادگی">
                <label for="">ایمیل<i class="fa fa-asterisk"></i></label><input type="email" name="email" placeholder="ایمیل">
                <label for="">نام کاربری<i class="fa fa-asterisk"></i></label><input type="text" name="username" placeholder="نام کاربری">
                <label for="">رمز عبور<i class="fa fa-asterisk"></i></label><input type="password" name="password" placeholder="رمز عبور">
                <input type="submit" name="register_admin" value="ثبت مشخصات">
                <input type="reset" value="پاک کردن">
            </form>
        </div>
        <div class="result col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php
                if (isset($_POST['register_admin']))
                {
                    $_POST = array_slice($_POST, 0,count($_POST) - 1);
                    call_user_func_array('check_values', array($_POST));
                }
            ?>
        </div>
    </div>
</div>
<hr>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table>
                <tr>
                    <th>ردیف</th>
                    <th>نام و نام خانوادگی</th>
                    <th>ایمیل</th>
                    <th>نام کاربری</th>
                    <th>اصلاح مشخصات</th>
                    <th>حذف</th>
                </tr>
                <?php

                    $data =
                        [
                            'fields' => [],
                            'values' => [],
                            'query' => 'SELECT * FROM `admin` ORDER BY `admin`.`id` DESC;'
                        ];
                    $result =  Model::run() -> c_find($data);
                    if ($result)
                    {
                        for ($i = 0; $i < count($result); $i++)
                        {
                            echo '
                                <tr>
                                    <td>'.($i + 1).'</td>
                                    <td>'.$result[$i]['fName'].' '.$result[$i]['lName'].'</td>
                                    <td>'.$result[$i]['email'].'</td>
                                    <td>'.$result[$i]['username'].'</td>
                                    <td><a href="'._base_url.'update_admin.php?id='.$result[$i]['id'].'">اصلاح مشخصات</a></td>
                                    <td><a href="#?" class="delete_admin" data-id="'.$result[$i]['id'].'">حذف</a></td>
                                </tr>
                            ';
                        }
                    }
                ?>

            </table>
        </div>
    </div>
</div>













<script type="text/javascript" src="<?= _base_url_3; ?>assets/lib/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= _base_url_3; ?>assets/lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" language="JavaScript">
    var delete_admin = get._class('delete_admin');
    for (var i = 0; i < delete_admin.length; i++)
    {
        delete_admin[i].addEventListener('click', function (e)
        {
            e.preventDefault();
            var id = this.getAttribute('data-id');
            var msg = confirm('آیا از حذف این مدیر مطمئن هستید؟');
            if (msg === true)
            {
                window.location.href = baseURL + "delete_admin.php?id=" + id;
            }
        });
    }
</script>
</body>
</html>
<?php
