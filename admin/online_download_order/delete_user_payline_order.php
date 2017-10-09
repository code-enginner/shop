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

    if (isset($_GET['id']))
    {
        $id = htmlspecialchars(intval($_GET['id']));
    }
    else
    {
        header('Location:'._base_url.'manage_online_download.php');
        exit();
    }

    $argument =
        [
            'fields' => [],
            'values' => [$id],
            'query' => 'DELETE FROM `payline` WHERE (`payline`.`user_id` = ?);'
        ];
    $result =  Model::run() -> c_find($argument);
    if ($result)
    {
        $argument_2 =
            [
                'fields' => [],
                'values' => [$id],
                'query' => 'DELETE FROM `user_order_links` WHERE (`user_order_links`.`user_id` = ?);'
            ];
        $result_2 =  Model::run() -> c_find($argument_2);
        if ($result_2)
        {
            header('Location:'._base_url.'manage_online_download.php');
            exit();
        }
    }