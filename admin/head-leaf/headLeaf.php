<?php

    use configReader\jsonReader;
    use functions\Model;

    require_once '../../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';
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
    <link rel="stylesheet" type="text/css" href="<?= _base_url_3; ?>assets/style/_head_leaf.css">
    <script type="text/javascript" src="<?= _base_url_3; ?>assets/script/myClass.js"></script>
    <script type="text/javascript"> var baseURL = "<?= _base_url; ?>"</script>
    <title>سربرگ</title>
</head>
<body dir="rtl">

<div class="container-fluid">
    <div class="row">
        <h4 class="head_leaf_header">تنظیم سربرگ</h4>
        <div class="content">

            <?php
                if (isset($_POST['register']))
                {
                    function checkValue()
                    {
                        try
                        {
                            if (!isset($_POST['text']) || !isset($_POST['address']) || !isset($_POST['level']))
                            {
                                throw new Exception(); // todo: create msg if $_POST's not set;
                            }
                            try
                            {
                                if (($_POST['text'] === '' || $_POST['text'] === NULL))
                                {
                                    throw new Exception();
                                }
                                else
                                {
                                    $data['text'] = htmlspecialchars($_POST['text']);
                                }

                                if ($_POST['address'] === '' || $_POST['address'] === NULL)
                                {
                                    $data['address'] = '#';
                                }
                                else
                                {
                                    $data['address'] = htmlspecialchars($_POST['address']);
                                    $data['level'] = htmlspecialchars($_POST['level']);
                                }

                                $arguments =
                                    [
                                        'id' => 'null',
                                        'values' => $data,
                                        'tableName' => 'headleaf',
                                        'allColumns' => TRUE,
                                        'fields'=> []
                                    ];

                                $result = Model::run() -> insert($arguments);
                                return $result;
                            }
                            catch (Exception $error)
                            {
                                throw new Exception(); // todo: create msg if fields are empty;
                            }
                        }
                        catch (Exception $error)
                        {
                            return $error -> getMessage();
                        }
                    }

                    $data = array_slice($_POST, 0, count($_POST) - 1);
                    echo call_user_func_array('checkValue', array($data));
                }
            ?>

            <div id="insert_head_leaf">
                <h5 class="header_insert">درج سربرگ جدید</h5>
                <form action="" method="post">
                    <label for=""><i class="fa fa-asterisk" aria-hidden="true"></i>متن سربرگ</label><input type="text" id="" class="" name="text" placeholder="متن سربرگ">
                    <label for="">آدرس (اختیاری)</label><input type="text" id="" class="" name="address" placeholder="آدرس (لینک) سربرگ"><br>
                    <label for="">تعین سطح سربرگ</label>
                    <select name="level" id="">
                        <option value="0" selected>به عنوان سربرگ اصلی</option>
                        <option value="" disabled></option>
                        <option value="" disabled>به عنوان زیر مجموعه:</option>
                        <?php
                            $data =
                                [
                                    'fields' => [],
                                    'values' => [],
                                    'query' => 'SELECT * FROM `headleaf`;',
                                ];
                            $result = Model::run()->c_find($data);
                            for ($i = 0; $i < count($result); $i++)
                            {
                                echo '
                                    <option value="'.$result[$i]['id'].'">'.$result[$i]['name'].'</option>
                                ';
                            }
                        ?>
                    </select>
                    <input type="submit" name="register" value="ذخیره">
                    <input type="reset" value="پاک کردن">
                </form>
            </div>
            <hr>
            <table>
                <tr>
                    <th>شماره</th>
                    <th>نام دسته</th>
                    <th> آدرس (لینک)</th>
                    <th>اصلاح</th>
                    <th>حذف</th>
                </tr>
             <?php

                 $arguments =
                     [
                         'data' => [],
                         'tableName' => 'headleaf',
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
                            <td>'.$result[$i]['name'].'</td>                    
                            <td>'.$result[$i]['address'].'</td>                    
                            <td><a href="'._base_url.'head_leaf_update.php?id='.$result[$i]['id'].'&tblname=headleaf&oldvalue='.$result[$i]['name'].'">اصلاح</a></td>
                            <td><a href="#?" id="'.$result[$i]['id'].'" class="deleteHeadleaf">حذف</a></td>                    
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
<script type="text/javascript" >
    var deleteHeadleaf = get._class('deleteHeadleaf');
    for (var i = 0; i < deleteHeadleaf.length; i++)
    {
        deleteHeadleaf[i].addEventListener('click', function ()
        {
            var delLeafMsg = confirm('آیا از حذف این سربرگ مطمئن هستید؟');
            var headleaf_id = this.getAttribute('id');
            if (delLeafMsg === true)
            {
                window.location = baseURL + 'head_leaf_delete.php?id=' + headleaf_id + '&tblname=<?php echo $arguments['tableName']; ?>';
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
