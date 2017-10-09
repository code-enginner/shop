<?php
    use configReader\jsonReader;
    use functions\Model;

    require_once '../../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'helperFunctions/sql_counter.php';
    require_once root.'vendor/autoload.php';
    if (!is_login())
    {
        header('Location:'._base_url_2.'login.php');
        exit();
    }

    if (!isset($_GET['id']) || intval($_GET['id']) == 0)
    {
        header('Location:'._base_url_2.'panel.php');
        exit();
    }
    else
    {
        $sysMsg = jsonReader::reade('systemMessage.json');
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
    <link rel="stylesheet" type="text/css" href="<?= _base_url_3; ?>assets/style/_manage_news.css">
    <script type="text/javascript" src="<?= _base_url_3; ?>assets/script/myClass.js"></script>
    <script type="text/javascript"> var baseURL = "<?= _base_url; ?>"</script>
    <title>به روز رسانی خبر</title>
</head>
<body dir="rtl">

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="set_news">
                <h5>درج اخبار جدید</h5>
                <?php
                    $data =
                        [
                            'fields' => [],
                            'values' => [$id],
                            'query' => 'SELECT * FROM `news` WHERE `news`.`id` = ?;'
                        ];
                    $result =  Model::run() -> c_find($data);
                    if ($result)
                    {
                        $text = $result[0]['text'];
                    }
                ?>
                <form action="" method="post">
                    <label for=""> متن خبر <i class="fa fa-asterisk"></i></label><textarea name="news_text" id="news_txt" cols="70" rows="10" placeholder="متن خبر را وارد کنید..."><?php if (isset($text)) {echo $text;} ?></textarea>
                    <input type="submit" name="update_news" value="به روز رسانی"><input type="reset" id="back" value="انصراف">
                </form>
            </div>

            <?php
                if (isset($_POST['update_news']))
                {
                    $values = [];
                    $_POST = array_slice($_POST, 0 ,count($_POST) - 1);
                    $values[] = $_POST['news_text'];
                    $values[] = $id;
                    $data_1 =
                        [
                            'fields' => [],
                            'values' => $values,
                            'query' => 'UPDATE `news` SET `news`.`text` = ? WHERE `news`.`id` = ?;'
                        ];
                    $result_1 =  Model::run() -> c_find($data_1);
                    if ($result_1)
                    {
                        echo $sysMsg['serverSuccess'][14]['msg14'];
                        header('refresh:1; url='._base_url.'manage_news.php');
                        exit();
                    }
                }
            ?>

        </div>
    </div>
</div>




<script type="text/javascript" src="<?= _base_url_3; ?>assets/lib/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= _base_url_3; ?>assets/lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" language="JavaScript">
    var bask = get._id('back');
    bask.addEventListener('click', function ()
    {
        window.location.href = baseURL + "manage_news.php";
    });
</script>
</body>
</html>
