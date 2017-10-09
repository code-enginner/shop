<?php

    use configReader\jsonReader;
    use functions\Model;

    require_once '../../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';
    require_once root.'admin/product/check_update_product.php';
    if (!is_login())
    {
        header('Location:'._base_url_2.'login.php');
        exit();
    }

    if (!isset($_GET['id']) || $_GET['id'] === '' || $_GET['id'] === NULL)
    {
        header('Location:'._base_url.'productManage.php');
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
    <link rel="stylesheet" type="text/css" href="<?= _base_url_3; ?>assets/style/_product_update.css">
    <script type="text/javascript" src="<?= _base_url_3; ?>assets/script/myClass.js"></script>
    <script language="JavaScript" src="<?= _base_url_3; ?>assets/lib/ckeditor/ckeditor.js"></script>
    <script type="text/javascript"> var baseURL = "<?= _base_url; ?>"</script>
    <title>Document</title>
</head>
<body dir="rtl">

<?php
    if (isset($_POST['updateProduct']) && isset($_FILES))
    {
        $sysMsg = jsonReader::reade('systemMessage.json');
        $_POST = array_slice($_POST, 0, count($_POST) - 1);
        $_POST = $_GET + $_POST + $_FILES;
        $result = call_user_func_array('product_dataUpdate_validation', array($_POST));
        if ($result === TRUE)
        {
            echo $sysMsg['serverSuccess'][6]['msg6'];
        }
        elseif($result === FALSE)
        {
            echo $sysMsg['serverError'][14]['msg14'];
        }
    }
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <?php

                try
                {
                    if ( ($_GET['id'] === '' || $_GET['id'] === NULL || !is_numeric($_GET['id'])) || ($_GET['tblname_1'] === '' || $_GET['tblname_1'] === NULL || !is_string($_GET['tblname_1'])) || ($_GET['tblname_2'] === '' || $_GET['tblname_2'] === NULL || !is_string($_GET['tblname_2'])))
                    {
                        throw new Exception();// todo: create msg if $_GET['id'] is not valid type;
                    }
                    else
                    {
                        $id = htmlspecialchars(intval($_GET['id']));
                        $tableName_1 = strtolower(htmlspecialchars($_GET['tblname_1']));
                        $tableName_2 = strtolower(htmlspecialchars($_GET['tblname_2']));

                        $arguments =
                            [
                                'data' => ['id' => $id],
                                'tableName' => $tableName_1,
                                'mathOp' => ['='],
                                'logicOp' => [],
                                'fetchAll' => FALSE
                            ];

                        $result = Model::run() -> find($arguments);
                        $oldValues = $result;

                        // Set Current Pic
                        $_SESSION['currentPic'] = $oldValues[0]['pic'];
                        try
                        {
                            if (count($result) === 0)
                            {
                                throw new Exception();
                            }
                        }
                        catch (Exception $error)
                        {
                            throw new Exception(); // todo: create msg if count $result is 0;
                        }
                    }
                }
                catch (Exception $error)
                {
                    exit($error -> getMessage());
                }

            ?>

            <form action="" method="post" enctype="multipart/form-data">
                <ul>
                    <li>
                        <label for="">نام محصول</label><input type="text" id="" name="productName" value="<?php if (isset($oldValues[0]['product_name'])) {echo $oldValues[0]['product_name'];}?>">
                    </li>

                    <li>
                        <label for="cat">دسته محصول</label>
                        <select id="cat" name="productCatId">
                            <?php
                                $arguments =
                                    [
                                        'data' => ['id' => $result[0]['cat_id']],
                                        'tableName' => $tableName_2,
                                        'mathOp' => ['='],
                                        'logicOp' => [],
                                        'fetchAll' => FALSE
                                    ];
                                $result = Model::run() -> find($arguments);
                                $oldCatId = $arguments['data']['id'];
                            ?>
                            <option value="<?php echo $arguments['data']['id']?>"><?php echo $result[0]['catName']?></option>
                            <?php
                                $arguments =
                                    [
                                        'data' => [],
                                        'tableName' => 'cat',
                                        'mathOp' => [],
                                        'logicOp' => [],
                                        'fetchAll' => TRUE
                                    ];
                                $result = Model::run() -> find($arguments);
                                for ($i = 0; $i < count($result); $i++)
                                {
                                    if ($result[$i]['id'] === $oldCatId)
                                    {
                                        continue;
                                    }
                                    echo '
                                           <option value="'.$result[$i]['id'].'">'.$result[$i]['catName'].'</option>
                                    ';
                                }
                            ?>
                        </select>
                    </li>

                    <li>
                        <span>موجود:</span><label for="">بله</label><input type="radio" id="" value="1" <?php if (isset($oldValues[0]['available']) && $oldValues[0]['available'] === '1') {echo 'checked';}?> name="productAvailable"><label for="">خیر</label><input type="radio" id="" value="0" <?php if (isset($oldValues[0]['available']) && $oldValues[0]['available'] === '0') {echo 'checked';}?> name="productAvailable">
                    </li>

                    <li>
                        <label for="">قیمت</label><input type="text" id="" name="productPrice" value="<?php if (isset($oldValues[0]['price'])) {echo $oldValues[0]['price'];}?>">
                    </li>

                    <li>
                        <label for="">رنگ</label>
                        <input type="color" id="" value="<?php if (isset($oldValues[0]['color'])) {echo $oldValues[0]['color'];}?>" name="productColor">

                    </li>

                    <li>
                        <label for="prdPic">درج عکس محصول</label><input type="file" id="prdPic" name="productPic">
                        <input type="hidden" name="POST_currentPic" value="<?= $oldValues[0]['pic']; ?>">
                        <div id="picPrev"><img src="<?php if (isset($oldValues[0]['pic'])) {echo _base_url.'product_pic/'.$oldValues[0]['pic'];}?>" alt="" width="200" height="300"></div>
                    </li>

                    <li>
                        <label for="ckEditor">متن کوتاه پیش نمایش</label><textarea name="shortText" id="ckEditor" cols="30" rows="10"><?php if (isset($oldValues[0]['short_text'])) {echo $oldValues[0]['short_text'];}?></textarea>
                    </li>

                    <li>
                        <label for="ckEditor">توضیحات</label><textarea name="productDescription" id="ckEditor" cols="30" rows="10"><?php if (isset($oldValues[0]['description'])) {echo $oldValues[0]['description'];}?></textarea>
                    </li>
                    <li>
                        <input type="submit" name="updateProduct" value=" به روزرسانی محصول ">
                        <input type="reset" value="پاک کردن">
                    </li>
                </ul>
            </form>
        </div>
    </div>
</div>


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
</body>
</html>
<?php
