<?php

    use configReader\jsonReader;
    use functions\Model;

    require_once '../../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';
    if (!is_login())
    {
        header('Location:'._base_url_2.'login.php');
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
    <link rel="stylesheet" type="text/css" href="<?= _base_url_3; ?>assets/style/_manage_users.css">
    <script type="text/javascript" src="<?= _base_url_3; ?>assets/script/myClass.js"></script>
    <script type="text/javascript"> var baseURL = "<?= _base_url; ?>";</script>
    <title>Document</title>
</head>
<body dir="rtl">


<div class="container-fluid">
    <div class="row">
        <table class="unSelect">
            <tr>
                <th>شماره</th>
                <th>نام و نام خانوادگی</th>
                <th>ایمیل</th>
                <th>تاریخ عضویت</th>
                <th>اطلاعات بیشتر</th>
                <th>حذف</th>
            </tr>

            <?php
                $arguments =
                    [
                        'data' => [],
                        'tableName' => 'users',
                        'mathOp' => [],
                        'logicOp' => [],
                        'fetchAll' => TRUE
                    ];
                $result = Model::run() -> find($arguments);
                for ($i = 0; $i < count($result); $i++)
                {
                    echo '
                        <tr>
                            <td>'.($i + 1).'</td>
                            <td>'.$result[$i]['name'].' '.$result[$i]['lastName'].'</td>
                            <td>'.$result[$i]['email'].'</td>
                            <td dir="ltr">'.date('Y : m : d / H : i : s A', $result[$i]['register_date']).'</td>
                            <td>
                                <span data-t="'.$result[$i]['id'].'" class="show_more_info">نمایش اطلاعات بیشتر<i class="fa fa-angle-down"></i></span>
                                <div class="more_info">
                                    <span class="more_info_header">شماره تلفن همراه</span><p class="more_info_content">'.$result[$i]['cellphone'].'</p>
                                    <span class="more_info_header">شماره تلفن ثابت</span><p class="more_info_content">'.$result[$i]['landline_phone'].'</p>
                                    <span class="more_info_header">شماره تلفن ضروری</span><p class="more_info_content">'.$result[$i]['necessary_phone'].'</p>
                                    <span class="more_info_header">کد پستی</span><p class="more_info_content">'.$result[$i]['postal_code'].'</p>
                                    <span class="more_info_header">آدرس</span><p class="more_info_content">'.$result[$i]['address'].'</p>
                                </div>
                            </td>
                            <td><a href="#?" data-id="'.$result[$i]['id'].'" class="deleteUser">حذف این کاربر</a></td>
                        </tr>
                    ';
                }
            ?>
        </table>
    </div>
</div>






<script type="text/javascript" src="<?= _base_url_3; ?>assets/lib/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= _base_url_3; ?>assets/lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= _base_url_3; ?>assets/script/script_6.js"></script>
<script type="text/javascript" language="JavaScript">
    var deleteUser = get._class('deleteUser');
    for (var i = 0; i < deleteUser.length; i++)
    {
        deleteUser[i].addEventListener('click', function (e)
        {
            e.preventDefault();
            var user_id = this.getAttribute('data-id');
            var del_msg = confirm('آیا از حذف این کاربر مطمئن هستید؟');
            if (del_msg === true)
            {
                window.location.href = baseURL + 'user_delete.php?id=' + user_id + '&tblname=<?= $arguments['tableName']; ?>';
            }
            else
            {
                window.location.href = '#?';
                return false;
            }
        });
    }
</script>
</body>
</html>
<?php
