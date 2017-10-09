<?php
    use configReader\jsonReader;
    use functions\Model;

    require_once '../../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';
    require_once root.'functions/jdf.php';
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
    <link rel="stylesheet" type="text/css" href="<?=_base_url_3; ?>assets/style/_manage_pay_product.css">
    <script type="text/javascript" src="<?= _base_url_3; ?>assets/script/myClass.js"></script>
    <script type="text/javascript" language="JavaScript">var baseURL = "<?= _base_url; ?>";</script>
    <title>Document</title>
</head>
<body dir="rtl">
<div class="container-fluid">
    <div class="row">
        <div class="main_content col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="result">
                <?php
                    $sysMsg = jsonReader::reade('systemMessage.json');
                    if (isset($_GET['delok']) && $_GET['delok'] == 't')
                    {
                        echo $sysMsg['serverSuccess'][11]['msg11'];
                    }
                    if (isset($_GET['delok']) && $_GET['delok'] == 'f')
                    {
                        echo $sysMsg['serverError'][32]['msg32'];
                    }
                ?>
            </div>
            <table>
                <tr>
                    <th>ردیف</th>
                    <th>نام محصول</th>
                    <th>لینک دانلود</th>
                    <th>قیمت</th>
                    <th>وضعیت موجودی</th>
                    <th>اصلاح</th>
                    <th>حذف</th>
                </tr>
                <?php
                    $arguments =
                        [
                            'fields' => [],
                            'values' => [],
                            'query' => 'SELECT * FROM `pay_download` ORDER BY `pay_download`.`id` DESC;'
                        ];
                    $result = Model::run()->c_find($arguments);
                    if ($result)
                    {
                        for ($i = 0; $i < count($result); $i++)
                        {
                            echo '
                                <tr>
                                    <td>'.($i + 1).'</td>
                                    <td>'.$result[$i]['p_name'].'</td>
                                    <td>'.$result[$i]['download_link'].'</td>
                                    <td>'.$result[$i]['p_price'].'  تومان </td>
                               
                                    ';

                            if ($result[$i]['p_available'] == 1)
                            {
                                echo '
                                    <td>
                                        <span class="status_result a_t"><i class="fa fa-check" aria-hidden="true"></i>موجود است</span>
                                        <a class="change_status" href="'._base_url.'change_status_pay_download_available.php?id='.$result[$i]['id'].'">تغییر وضعیت</a>
                                    </td>
                                ';
                            }
                            else
                            {
                                echo '
                                    <td>
                                        <span class="status_result a_f"><i class="fa fa-times" aria-hidden="true"></i>نا موجود</span>
                                        <a class="change_status" href="'._base_url.'change_status_pay_download_available.php?id='.$result[$i]['id'].'">تغییر وضعیت</a>
                                    </td>
                                ';
                            }

                            echo '
                                    
                                    <td><a href="'._base_url.'update_pay_product.php?id='.$result[$i]['id'].'">اصلاح</a></td>
                                    <td><a href="#?" data-id="'.$result[$i]['id'].'" class="delete_pay_p">حذف</a></td>
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
    var delete_pay_p = get._class('delete_pay_p');
    for (var i = 0; i < delete_pay_p.length; i++)
    {
        delete_pay_p[i].addEventListener('click', function (e)
        {
            e.preventDefault();
            var id = this.getAttribute('data-id');
            var msg = confirm('آیا از حذف این کاربر مطمئن هستید؟');
            if (msg === true)
            {
                window.location.href = baseURL + "delete_pay_product.php?id=" + id;
            }
        });
    }
</script>
</body>
</html>
<?php
