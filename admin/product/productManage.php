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
    <link rel="stylesheet" type="text/css" href="<?= _base_url_3; ?>assets/style/_product_manage.css">
    <script type="text/javascript" src="<?= _base_url_3; ?>assets/script/myClass.js"></script>
    <script type="text/javascript"> var baseURL = "<?= _base_url; ?>"</script>
    <title>Document</title>
</head>
<body dir="rtl">

<div class="container-fluid">
    <div class="row">
        <div class="product_manage_content">
            <table>
                <tr>
                    <th>شماره</th>
                    <th>نام محصول</th>
                    <th>اصلاح</th>
                    <th>حذف</th>
                </tr>
                <?php

                    $arguments =
                        [
                            'data' => [],
                            'tableName' => 'product',
                            'mathOp' => [],
                            'logicOp' => [],
                            'fetchAll' => TRUE
                        ];
                    $id = NULL;
                    $result = Model::run() -> find($arguments);
                    for ($i = 0; $i < count($result); $i++)
                    {
                        echo '
                        <tr>
                            <td>'.($i + 1).'</td>
                            <td>'.$result[$i]['product_name'].'</td>
                            <td><a href="'._base_url.'product_update.php?id='.$result[$i]['id'].'&tblname_1='.$arguments['tableName'].'&tblname_2=cat">اصلاح</a></td>
                            <td><a id="'.$result[$i]['id'].'" data-pic="'.$result[$i]['pic'].'" class="deleteProduct" href="#?">حذف</a></td>
                        </tr>
                    ';
//                        $_SESSION['oldPic'] = $result[$i]['pic'];
                    }
                ?>
            </table>
        </div>
    </div>
</div>




<script type="text/javascript" src="<?= _base_url_3; ?>assets/lib/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= _base_url_3; ?>assets/lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" language="JavaScript">
    var deleteProduct = get._class('deleteProduct');
    for (var i = 0; i < deleteProduct.length; i++)
    {
        deleteProduct[i].addEventListener('click', function ()
        {
            var delPrd = confirm('آیا از حذف این محصول مطمئن هستید؟');
            var product_id = this.getAttribute('id');
            var pic = this.getAttribute('data-pic');
            if (delPrd === true)
            {
                window.location.href = baseURL + 'product_delete.php?id=' + product_id + '&tblname=<?php echo $arguments['tableName']; ?>&pic=' + pic;
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

    if (isset($_GET['delOk']) && $_GET['delOk'] == 1)
    {
//        unlink(root.'admin/product/product_pic/'.$_SESSION['oldPic']);
    }