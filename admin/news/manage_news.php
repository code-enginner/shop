<?php
    use configReader\jsonReader;
    use functions\Model;

    require_once '../../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'helperFunctions/sql_counter.php';
    require_once root.'vendor/autoload.php';
    require_once root.'admin/news/check_register_news.php';
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
    <link rel="stylesheet" type="text/css" href="<?= _base_url_3; ?>assets/style/_manage_news.css">
    <script type="text/javascript" src="<?= _base_url_3; ?>assets/script/myClass.js"></script>
    <script type="text/javascript"> var baseURL = "<?= _base_url; ?>"</script>
    <title>مدیریت اخبار</title>
</head>
<body dir="rtl">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="set_news">
                <h5>درج اخبار جدید</h5>
                <form action="" method="post">
                    <label for=""> متن خبر <i class="fa fa-asterisk"></i></label><textarea name="news_text" id="news_txt" cols="70" rows="10" placeholder="متن خبر را وارد کنید..."></textarea>
                    <input type="submit" name="register_news" value="ثبت خبر"><input type="reset" value="پاک کردن">
                </form>
            </div>
        </div>
    </div>
</div>
<?php
    if (isset($_POST['register_news']))
    {
        $_POST = array_slice($_POST, 0, count($_POST) - 1);
        $result_call = call_user_func_array('check_inputs', array($_POST));
        dump($result_call);
    }
?>

<hr>
<div class="container-fluid">
    <div class="row">
        <div id="result_scope" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table>
                <tr>
                    <th>ردیف</th>
                    <th>متن خبر</th>
                    <th>وضعیت نمایش خبر</th>
                    <th>اصلاح</th>
                    <th>حذف</th>
                </tr>

                <?php
                    $data =
                        [
                            'fields' => [],
                            'values' => [],
                            'query' => 'SELECT * FROM `news` ORDER BY `news`.`id` DESC;'
                        ];
                    $result =  Model::run() -> c_find($data);
                    for ($i = 0; $i < count($result); $i++)
                    {
                        echo '
                            <tr>
                                <td>'.($i + 1).'</td>
                                <td>'.$result[$i]['text'].'</td>';

                        if ($result[$i]['status'] == 0)
                        {
                            echo '
                                <td>
                                    <span class="status_result news_hide"><i class="fa fa-times" aria-hidden="true"></i>خبر غیر قابل نمایش است</span>
                                    <a class="change_status" href="'._base_url.'change_status.php?id='.$result[$i]['id'].'">خبر را نمایش بده</a>
                                </td>
                            ';
                        }

                        if ($result[$i]['status'] == 1)
                        {
                            echo '
                                <td>
                                    <span class="status_result news_show"><i class="fa fa-check" aria-hidden="true"></i>خبر قابل نمایش است</span>
                                    <a class="change_status" href="'._base_url.'change_status.php?id='.$result[$i]['id'].'">خبر را مخفی کن</a>
                                </td>
                            ';
                        }

                    echo '
                                <td><a href="'._base_url.'news_update.php?id='.$result[$i]['id'].'">اصلاح خبر</a></td>
                                <td><a href="javascript:()" class="delete_news" onclick="delNews('.$result[$i]['id'].')" data-id="'.$result[$i]['id'].'">حذف خبر</a></td>
                            </tr>
                        ';
                    }
                ?>
            </table>
        </div>
    </div>
</div>


<script type="text/javascript" src="<?= _base_url_3; ?>assets/lib/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= _base_url_3; ?>assets/lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" language="JavaScript">
//    function delNews(id)
//    {
//        var data, result, msg, ajax_request;
//
//        data = {"id":id};
//        data = JSON.stringify(data);
//        result = get._id('result_scope');
//        msg = confirm('آیا از حذف این خبر مطمئن هستید؟');
//        if (msg === true)
//        {
//            var http = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
//            http.onreadystatechange = function ()
//            {
//                if (this.readyState === 4 && this.status === 200)
//                {
////                    document.getElementById('result_scope').innerHTML = '';
//                    result.innerHTML = this.responseText;
//                }
//            };
//            http.open('POST', baseURL + 'news_delete_ajax.php', true);
//            http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
//            http.send(data);
//        }
//    }

    function delNews(id)
    {
        var data, result, msg, ajax_request;
        data = {"id":id};
        result = get._id('result_scope');
        msg = confirm('آیا از حذف این خبر مطمئن هستید؟');
        if (msg === true)
        {
            ajax_request = new Request
            ({
                _values: data,
                _method: 'post',
                _async: true,
                _fileSystem: baseURL + 'news_delete_ajax.php'
            }, result, 'text');
            ajax_request.call();
        }
    }
</script>
</body>
</html>
<?php
