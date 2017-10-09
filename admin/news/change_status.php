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


    if (!isset($_GET['id']) || $_GET['id'] === '' || $_GET['id'] === NULL || intval($_GET['id']) == 0)
    {
        header('Location:'._base_url.'manage_news.php');
        exit();
    }
    else
    {
        $id = htmlspecialchars(intval($_GET['id']));

        $data_0 =
            [
                'fields' => [],
                'values' => [$id],
                'query' => 'SELECT `news`.`status` FROM `news` WHERE `news`.`id` = ?;'
            ];
        $check_status =  Model::run() -> c_find($data_0);
        if ($check_status)
        {
            if ($check_status[0]['status'] == 1)
            {
                $data =
                    [
                        'fields' => [],
                        'values' => [$id],
                        'query' => 'UPDATE `news` SET `news`.`status` = 0 WHERE `news`.`id` = ?;'
                    ];
                $result =  Model::run() -> c_find($data);
                if ($result)
                {
                    header('Location:'._base_url.'manage_news.php');
                    exit();
                }
            }

            if ($check_status[0]['status'] == 0)
            {
                $data =
                    [
                        'fields' => [],
                        'values' => [$id],
                        'query' => 'UPDATE `news` SET `news`.`status` = 1 WHERE `news`.`id` = ?;'
                    ];
                $result =  Model::run() -> c_find($data);
                if ($result)
                {
                    header('Location:'._base_url.'manage_news.php');
                    exit();
                }
            }
        }
    }