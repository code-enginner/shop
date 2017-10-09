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

    if ( (!isset($_GET['i']) || !isset($_GET['f'])) || intval($_GET['f']) == 0)
    {
        header('Location:'._base_url.'manage-order.php');
        exit();
    }
    else
    {
        $order_id = strip_tags(intval($_GET['i']));

        if ($_GET['f'] == 10)
        {
            $data =
                [
                    'fields' => [],
                    'values' => [$order_id],
                    'query' => 'UPDATE `user_order` SET `user_order`.`status` = 0 WHERE `user_order`.`order_id` = ?;'
                ];
            $result = Model::run() -> c_find($data);
            if ($result)
            {
                header('Location:'._base_url.'manage_order.php?u=ok');
                exit();
            }
            else
            {
                header('Location:'._base_url.'manage_order.php?u=wrong');
                exit();
            }
        }

        if ($_GET['f'] == 01)
        {
            $data =
                [
                    'fields' => [],
                    'values' => [$order_id],
                    'query' => 'UPDATE `user_order` SET `user_order`.`status` = 1 WHERE `user_order`.`order_id` = ?;'
                ];
            $result = Model::run() -> c_find($data);
            if ($result)
            {
                header('Location:'._base_url.'manage_order.php?u=ok');
                exit();
            }
            else
            {
                header('Location:'._base_url.'manage_order.php?u=wrong');
                exit();
            }
        }


    }