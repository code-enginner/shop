<?php

    use configReader\jsonReader;
    use functions\Model;

    require_once '../../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';


//    dump(_base_url);
//    dump(_base_url_2);
//    dump(_base_url_3, TRUE);

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
    <link rel="stylesheet" type="text/css" href="<?= _base_url_3; ?>assets/style/_manage_comments.css">
    <script type="text/javascript" src="<?= _base_url_3; ?>assets/script/myClass.js"></script>
    <script type="text/javascript"> var baseURL = "<?= _base_url; ?>";</script>
    <title>Document</title>
</head>
<body dir="rtl">


<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php
                if (isset($_GET['confirm']) && $_GET['confirm'] === 'show' && isset($_GET['prn']) && isset($_GET['un']))
                {
                    $username = htmlspecialchars($_GET['un']);
                    $productname = htmlspecialchars($_GET['prn']);
                    echo '<div class="alert alert-success success"><h5><i class="fa fa-window-close"></i><i class="break_line"></i> نظر '.$username.' در مورد کالای '.$productname.' با موفقیت تایید شد.</h5></div>';
                }

                if (isset($_GET['confirm']) && $_GET['confirm'] === 'hide' && isset($_GET['prn']) && isset($_GET['un']))
                {
                    $username = htmlspecialchars($_GET['un']);
                    $productname = htmlspecialchars($_GET['prn']);
                    echo '<div class="alert alert-success success"><h5><i class="fa fa-window-close"></i><i class="break_line"></i> نظر '.$username.' در مورد کالای '.$productname.' لغو تایید شد.</h5></div>';
                }
            ?>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table>
                <tr>
                    <th>شماره</th>
                    <th>نام کاربر</th>
                    <th>ایمیل</th>
                    <th>محتوای نظر کاربر</th>
                    <th>تاریخ ارسال</th>
                    <th>نام محصول</th>
                    <th>وضعیت انتشار</th>
                    <th>حذف</th>
                </tr>

                <?php
                    $sysMSG = jsonReader::reade('systemMessage.json');
                    $product_id = [];
                    $arguments =
                        [
                            'data' => [],
                            'tableName' => 'comment',
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
                                <td>'.$result[$i]['comment'].'</td>
                                <td dir="ltr">'.date('Y : m : d / H : i : s A', $result[$i]['comment_date']).'</td>
                                <td>'.$result[$i]['product_name'].'<a href="'._base_url_3.'showProduct.php?id='.$result[$i]['product_id'].'&tblname=product" target="_blank">نمایش محصول</a></td>
                                <td>
                                    <a href="'._base_url.'accept_comment.php?id='.$result[$i]['id'].'&productname='.$result[$i]['product_name'].'&un='.$result[$i]['name'].' '.$result[$i]['lastName'].'">تایید و انتشار نظر</a>';

                        if ($result[$i]['status'] == 1)
                        {
                            echo '<span class="confirm">تایید شده</span>';
                        }
                        else
                        {
                            echo '<span class="not_confirm">تایید نشده</span>';
                        }


                        echo '<a href="'._base_url.'unaccept_comment.php?id='.$result[$i]['id'].'&productname='.$result[$i]['product_name'].'&un='.$result[$i]['name'].' '.$result[$i]['lastName'].'">لغو تایید و انتشار</a>';

                        echo '
                                </td>
                                <td><a href="#?" class="deleteComment" data-id="'.$result[$i]['id'].'">حذف نظر</a></td>
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
<script type="text/javascript" src="<?= _base_url_3; ?>"></script>
<script type="text/javascript" language="JavaScript">
    var deleteComment = get._class('deleteComment');
    for (var i = 0; i < deleteComment.length; i++)
    {
        deleteComment[i].addEventListener('click', function (e)
        {
            e.preventDefault();
            var comment_id = this.getAttribute('data-id');
            var del_msg = confirm('آیا از حذف کردن نظر این کاربر مطمئن هستید؟');
            if (del_msg === true)
            {
                window.location = baseURL + 'comment_delete.php?id=' + comment_id + '&tblname=<?= $arguments['tableName']; ?>';
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
