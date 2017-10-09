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


    if (!isset($_GET['id']))
    {
        header('Location:'._base_url.'manage_account.php');
        exit();
    }
    else
    {
        $id = htmlspecialchars(intval($_GET['id']));
        $data =
            [
                'fields' => [],
                'values' => [$id],
                'query' => 'DELETE FROM `admin` WHERE (`admin`.`id` = ?);'
            ];
        $result =  Model::run() -> c_find($data);
        if ($result)
        {
            header('Location:'._base_url.'manage_account.php');
            exit();
        }
    }