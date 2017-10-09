<?php
    use configReader\jsonReader;
    use functions\Model;

    require_once '../../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';

    if (isset($_GET['id']) && isset($_GET['productname']) && isset($_GET['un']))
    {
        $id = htmlspecialchars(intval($_GET['id']));
        $productname = htmlspecialchars($_GET['productname']);
        $username = htmlspecialchars($_GET['un']);
        $data =
            [
                'fields' => [],
                'values' => [$id],
                'query' => 'UPDATE `comment` SET `status` = 0 WHERE `id` = ?;',
            ];
        $result =  Model::run() -> c_find($data);
        header('Location:'._base_url.'manage_comments.php?confirm=hide&prn='.$productname.'&un='.$username);
        exit();
    }
    else
    {
        header('Location:'._base_url_3.'index.php');
        exit();
    }