<?php

    use configReader\jsonReader;
    use functions\Model;


    require_once '../../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';
    require_once root.'admin/product/check_insert_product.php';


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
    <link rel="stylesheet" type="text/css" href="<?= _base_url_3; ?>assets/style/_insert_product.css">
    <script type="text/javascript" src="<?= _base_url_3; ?>assets/script/myClass.js"></script>
    <script language="JavaScript" src="<?= _base_url_3; ?>assets/lib/ckeditor/ckeditor.js"></script>

    <title>Document</title>
</head>
<body dir="rtl">


<?php

    if (isset($_POST['insertProduct']) && isset($_FILES['productPic']) && isset($_SESSION['catNames']))
    {
        $arguments =
            [
                $_SESSION['catNames'],
                $_POST,
                $_FILES
            ];
        $result = call_user_func_array('product_data_validation', array($arguments));
        echo $result;
    }
?>


<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form action="" method="post" enctype="multipart/form-data">
                <ul>
                    <li>
                        <label for="">نام محصول</label><input type="text" id="" name="productName" value="<?php if (isset($_POST['productName'])) {echo $_POST['productName'];}?>">
                    </li>

                    <li>
                        <label for="">دسته مربوط به محصول</label>
                        <select id="" name="productCatId">
                            <option value="">انتخاب دسته محصول</option>
                            <option value=""></option>';
                            <?php
                                $arguments =
                                    [
                                        'data' => [],
                                        'tableName' => 'cat',
                                        'mathOp' => [],
                                        'logicOp' => [],
                                        'fetchAll' => TRUE
                                    ];

                                $catNames = [];
                                $result = Model::run() -> find($arguments);
                                for ($i = 0; $i < count($result); $i++)
                                {
                                    echo '
                                           <option value="'.$result[$i]['id'].'">'.$result[$i]['catName'].'</option>    
                                    ';
                                    $catNames[$result[$i]['id']] = $result[$i]['catName'];
                                }
                                $_SESSION['catNames'] = $catNames;
                            ?>
                        </select>
                    </li>

                    <li>
                        <span>آیا محصول در انبار موجود است:</span><label for="">بله</label><input type="radio" id="" value="1" name="productAvailable" checked><label for="">خیر</label><input type="radio" id="" value="0" name="productAvailable">
                    </li>

                    <li>
                        <label for="">قیمت محصول</label><input type="text" id="" name="productPrice" value="<?php if (isset($_POST['productPrice'])) {echo $_POST['productPrice'];}?>">
                    </li>

                    <li>
                        <label for="">انتخاب رنگ محصول</label>
                        <input type="color" id="" value="#ff00ff" name="productColor">

                    </li>

                    <li>
                        <label for="prdPic">درج عکس محصول</label><input type="file" id="prdPic" name="productPic">
                        <div id="picPrev"><img src="" alt="" width="300" height="300"></div>
                    </li>

                    <li>
                        <label for="ckEditor">متن کوتاه پیش نمایش برای محصول</label><textarea name="shortText" id="ckEditor" cols="30" rows="10"><?php if (isset($_POST['shortText'])) {echo $_POST['shortText'];}?></textarea>
                    </li>

                    <li>
                        <label for="ckEditor">توضیحات کامل محصول</label><textarea name="productDescription" id="ckEditor" cols="30" rows="10"><?php if (isset($_POST['productDescription'])) {echo $_POST['productDescription'];}?></textarea>
                    </li>
                    <li>
                        <input type="submit" name="insertProduct" value="درج محصول">
                        <input type="reset" value="پاک کردن">
                    </li>
                </ul>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= _base_url_3; ?>assets/lib/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= _base_url_3; ?>assets/lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" language="JavaScript">
    CKEDITOR.replace('productDescription',
    {
        language: 'fa'
    });

    CKEDITOR.replace('shortText',
        {
            language: 'fa'
        });
</script>
<script type="text/javascript" src="<?= _base_url_3; ?>assets/script/script.js"></script>
</body>
</html>
<?php

