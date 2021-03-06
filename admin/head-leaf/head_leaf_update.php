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

    if (!isset($_GET['id']) || !isset($_GET['tblname']))
    {
        $_SESSION['lName'] = '';
        $_SESSION['fName'] = '';
        $_SESSION['email'] = '';
        unset($_SESSION['lName']);
        unset($_SESSION['fName']);
        unset($_SESSION['email']);
        header('Location:'._base_url_2.'panel.php');
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
    <link rel="stylesheet" type="text/css" href="<?= _base_url_3; ?>assets/style/_head_leaf_update.css">
    <script type="text/javascript" src="<?= _base_url_3; ?>assets/script/myClass.js"></script>
    <script type="text/javascript"> var baseURL = "<?= _base_url; ?>"</script>

    <title>بروز رسانی سربرگ</title>
</head>
<body dir="rtl">

<div class="container-fluid">
    <div class="row">
        <h3 id="header">بروز رسانی سربرگ</h3>
        <div class="content">
            <form action="" method="post">
                <label for="leafName">نام سربرگ<i class="forced">*</i></label><i ></i><input type="text" name="name" id="leafName" value="<?php if (isset($_GET['oldvalue'])) {echo $_GET['oldvalue'];} ?>">
                <input type="submit" name="set_new_leafName" value="به روز کن">
                <input type="reset" value="پاک کن">
            </form>
            <button id="back" onclick="backPage('headLeaf.php')">برگشت</button>
        </div>
    </div>
</div>


<script type="text/javascript" src="<?= _base_url_3; ?>assets/lib/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= _base_url_3; ?>assets/lib/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= _base_url_3; ?>assets/script/script_2.js"></script>
</body>
</html>

<?php

    $sysMsg = jsonReader::reade('systemMessage.json');
    try
    {
        if (($_GET['id'] === '' || $_GET['id'] === NULL || !is_numeric($_GET['id'])) || ($_GET['tblname'] === '' || $_GET['tblname'] === NULL || !is_string($_GET['tblname'])))
        {
            throw new Exception(); // todo: create msg if $_GET is empty;
        }
    }
    catch (Exception $error)
    {
        echo $error -> getMessage();
    }

    if (isset($_POST['set_new_leafName']) && isset($_POST['name']))
    {
        try
        {
            if ($_POST['name'] === '' || $_POST['name'] === NULL)
            {
                throw new Exception($sysMsg['userError'][4]['msg4']);
            }
            $values = [];
            $values['name'] = htmlspecialchars(trim($_POST['name']));
            $id = NULL;
            $tableName = NULL;
            foreach ($_GET as $key => $value)
            {
                switch ($key)
                {
                    case 'id':
                        $id = htmlspecialchars(intval($_GET[$key]));
                        break;
                    case 'tblname':
                        $tableName = strtolower(htmlspecialchars($_GET[$key]));
                        break;
                }
            }
            $arguments =
                [
                    'id' => $id,
                    'values' => $values,
                    'tableName' => $tableName,
                    'mathOp' => ['='],
                    'logicOp' => [],
                ];

            if ($result = Model::run() -> insert($arguments))
            {
                header('refresh:1;url='. _base_url .'headLeaf.php?updok=1');
                exit();
            }
            else
            {
                echo $result;
            }
        }
        catch (Exception $error)
        {
            echo $error -> getMessage();
        }
    }
