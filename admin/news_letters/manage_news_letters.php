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
    <link rel="stylesheet" type="text/css" href="<?= _base_url_3; ?>assets/style/_manage_news_letters.css">
    <script type="text/javascript" src="<?= _base_url_3; ?>assets/script/myClass.js"></script>
    <script type="text/javascript"> var baseURL = "<?= _base_url; ?>"</script>
    <title>Document</title>
</head>
<body dir="rtl">

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table>
                <tr>
                    <th>ردیف</th>
                    <th>ایمیل</th>
                    <th>وضعیت ارسال</th>
                    <th>حذف</th>
                </tr>
                <?php
                    $arguments =
                        [
                            'fields' => [],
                            'values' => [],
                            'query' => 'SELECT * FROM `news_letters` ORDER BY `news_letters`.`id` DESC;'
                        ];
                    $result = Model::run()->c_find($arguments);
                    if ($result)
                    {
                        for ($i = 0; $i < count($result); $i++)
                        {
                            echo '
                                <tr>
                                    <td>'.($i + 1).'</td>
                                    <td>'.$result[$i]['email'].'</td>';

                            if ($result[$i]['status'] == 0)
                            {
                                echo '
                                <td>
                                    <span class="status_result news_hide"><i class="fa fa-times" aria-hidden="true"></i>خبرنامه ارسال نمی شود</span>
                                    <a class="change_status" href="'._base_url.'change_status_news-letters.php?id='.$result[$i]['id'].'">ارسال خبرنامه را فعال کن</a>
                                </td>
                            ';
                            }

                            if ($result[$i]['status'] == 1)
                            {
                                echo '
                                <td>
                                    <span class="status_result news_show"><i class="fa fa-check" aria-hidden="true"></i>خبرنامه ارسال می شود</span>
                                    <a class="change_status" href="'._base_url.'change_status_news-letters.php?id='.$result[$i]['id'].'">ارسال خبرنامه را غیر فعال کن</a>
                                </td>
                            ';
                            }


                        echo '
                                    <td><a href="#?" class="delete_news_letters" data-id="'.$result[$i]['id'].'">حذف از گروه</a></td>
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
    var delete_news_letters = get._class('delete_news_letters');
    for (var i = 0; i < delete_news_letters.length; i++)
    {
        delete_news_letters[i].addEventListener('click', function (e)
        {
            e.preventDefault();
            var id = this.getAttribute('data-id');
            var msg = confirm('آیا از حذف این کاربر مطمئن هستید؟');
            if (msg === true)
            {
                window.location.href = baseURL + "delete_news_letters.php?id=" + id;
            }
        });
    }
</script>
</body>
</html>
<?php
