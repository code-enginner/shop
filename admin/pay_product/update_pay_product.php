<?php
    use configReader\jsonReader;
    use functions\Model;

    require_once '../../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';
    require_once root.'functions/jdf.php';
    require_once root.'admin/pay_product/check_update_pay_download.php';
    if (!is_login())
    {
        header('Location:'._base_url_2.'login.php');
        exit();
    }

    if (!isset($_GET['id']))
    {
        header('Location:'._base_url.'manage_pay_product.php');
        exit();
    }
    else
    {
        $id = htmlspecialchars(intval($_GET['id']));
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
    <link rel="stylesheet" type="text/css" href="<?= _base_url_3; ?>assets/style/_by_download.css">
    <script type="text/javascript" src="<?= _base_url_3; ?>assets/script/myClass.js"></script>
    <script language="JavaScript" src="<?= _base_url_3; ?>assets/lib/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" language="JavaScript">var baseURL = "<?= _base_url; ?>";</script>
    <title>Document</title>
</head>
<body dir="rtl">

<div class="container-fluid">
    <div class="row">
        <div class="main_content col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h5 class="header">به روز رسانی محصول</h5>
            <div class="result col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="result">
                    <?php
                        if (isset($_POST['update']))
                        {
                            $_POST = array_slice($_POST, 0, count($_POST) - 1);
                            call_user_func_array('check_update_values', array($_POST));
                        }
                    ?>
                </div>
                <form action="" method="post">
                <?php
                    $arguments =
                        [
                            'fields' => [],
                            'values' => [$id],
                            'query' => 'SELECT * FROM `pay_download` WHERE `pay_download`.`id` = ?;'
                        ];
                    $result = Model::run()->c_find($arguments);
                    if ($result)
                    {
                        for ($i = 0; $i < count($result); $i++)
                        {
                            echo '
                                <label for=""> نام<i class="fa fa-asterisk"></i></label><input type="text" name="name" placeholder="نام محصول" value="'.$result[$i]['p_name'].'">
                                <label for="">لینک دانلود<i class="fa fa-asterisk"></i></label><input id="l_d" type="text" name="download_link" placeholder="لینک دانلود محصول" value="'.$result[$i]['download_link'].'">
                                <label for="">قیمت<i class="fa fa-asterisk"></i></label><input type="text" name="price" placeholder="قیمت محصول" value="'.$result[$i]['p_price'].'">
                                <label for="">توضیحات کوتاه<i class="fa fa-asterisk"></i></label><textarea name="short_text" id="" placeholder="توضیحات کوتاه" cols="70" rows="10">'.$result[$i]['p_short_text'].'</textarea>
                                <label for="">توضیحات کامل<i class="fa fa-asterisk"></i></label><textarea name="long_text" id="ckEditor" class="long_text" placeholder="توضیحات کامل"  cols="30" rows="10">'.$result[$i]['p_long_text'].'</textarea>  
                            ';
                        }
                    }
                ?>
                    <input type="submit" name="update" value="به روز کردن محصول">
                    <input type="reset" id="back" value="انصراف">
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?= _base_url_3; ?>assets/lib/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= _base_url_3; ?>assets/lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" language="JavaScript">
    CKEDITOR.replace('long_text',
        {
            language: 'fa'
        });

    var l_d = get._id('l_d');
    l_d.addEventListener('click', function ()
    {
        l_d.placeholder = '';
        l_d.style.direction = 'ltr';
    });

    l_d.addEventListener('blur', function ()
    {
        l_d.placeholder = 'لینک دانلود محصول';
        l_d.style.direction = 'rtl';
    });

    var back = get._id('back');
    back.addEventListener('click', function ()
    {
        window.location.href = baseURL + 'manage_pay_product.php';
    });
</script>
</body>
</html>
<?php
