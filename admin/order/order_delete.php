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

    if (!isset($_GET['order_id']) || intval($_GET['order_id']) === 0)
    {
        header('Location:'._base_url.'manage_order.php');
        exit();

    }
    else
    {
        $order_id = strip_tags(intval($_GET['order_id']));

        $data =
            [
                'fields' => [],
                'values' => [$order_id],
                'query' => 'DELETE FROM `user_order` WHERE `user_order`.`order_id` = ? ;'
            ];
        $result = Model::run() -> c_find($data);

        if ($result)
        {
            $data_2 =
                [
                    'fields' => [],
                    'values' => [$order_id],
                    'query' => 'DELETE FROM `basket` WHERE `basket`.`status` = ? ;'
                ];
            $result_2 = Model::run() -> c_find($data_2);

            if ($result_2)
            {
                header('Location:'._base_url.'manage_order.php?delOk=1');
                exit();
            }
            else
            {
                header('Location:'._base_url.'manage_order.php?delError=1');
                exit();
            }
        }
        else
        {
            header('Location:'._base_url.'manage_order.php?delError=11');
            exit();
        }
    }

