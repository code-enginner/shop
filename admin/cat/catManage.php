<?php

    use configReader\jsonReader;
    use functions\Model;

    require_once '../../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';
    if (!is_login())
    {
        header('Location:'._base_url.'login.php');
        exit();
    }

    $sysMsg = jsonReader::reade('systemMessage.json');      // getting the content of system message file
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
    <link rel="stylesheet" type="text/css" href="<?= _base_url_3; ?>assets/style/_cat_manage.css">
    <script type="text/javascript" src="<?= _base_url_2; ?>assets/script/myClass.js"></script>
    <script type="text/javascript"> var baseURL = "<?= _base_url; ?>"</script>
    <title>Document</title>
</head>
<body dir="rtl">

<div id="insert">
    <?php
        if (isset($_POST['catInsert']))
        {
            $data = $_POST;
            $result = call_user_func_array('insert', array($data));
            echo $result;
        }
    ?>
    <form action="" method="post">
        <label for="catName">نام دسته:</label><input type="text" name="catName" id="catName">
        <input type="submit" name="catInsert" value="درج دسته" id="catInsert">
    </form>
</div>

<div id="all">
   <table>
       <tr>
           <th>شماره</th>
           <th>نام دسته</th>
           <th>نام مدیر</th>
           <th>ایمیل مدیر</th>
           <th>بروز رسانی</th>
           <th>حذف</th>
       </tr>
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
               echo ' 
                <tr>
                    <td>'.($i + 1).'</td>
                    <td>'.$result[$i]['catName'].'</td>
                    <td>'.$result[$i]['adminName'].'</td>
                    <td>'.$result[$i]['adminEmail'].'</td>
                    <td><a href="'._base_url.'cat_update.php?id='.$result[$i]['id'].'&tname='.$arguments['tableName'].'&oldvalue='.$result[$i]['catName'].'">بروز رسانی دسته</a></td>
                    <td><a href="'._base_url.'cat_delete.php?id='.$result[$i]['id'].'&tname='.$arguments['tableName'].'">حذف دسته</a></td>
                </tr>
           ';
           }

           if (isset($_GET['delok']) && $_GET['delok'] == 1)
           {
               //todo: create timer to hide the delete success msg;

               echo $sysMsg['serverSuccess'][2]['msg2'];
           }
       ?>

   </table>
</div>





<script type="text/javascript" src="<?= _base_url_3; ?>assets/lib/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= _base_url_3; ?>assets/lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= _base_url_3; ?>assets/script/script.js"></script>
</body>
</html>
<?php

    function insert(array $data)
    {
        $sysMsg = jsonReader::reade('systemMessage.json');
        $data = array_slice($data, 0, count($data) - 1);
        foreach ($data  as $key => $value)
        {
            try
            {
                if ($value === NULL || $value === '')
                {
                    throw new Exception($sysMsg['userError'][3]['msg3']);
                }
                else
                {
                    $data[$key] = htmlspecialchars($value);
                }
            }
            catch (Exception $error)
            {
                return $error -> getMessage();
            }
        }
        $data['adminName'] = $_SESSION['lName'].' '.$_SESSION['fName'];
        $data['adminEmail'] = $_SESSION['email'];

        $arguments =
            [
                'id' => 'null',
                'values' => $data,
                'tableName' => 'cat',
                'allColumns' => TRUE,
                'fields'=> []
            ];

        return Model::run() -> insert($arguments);
    }

