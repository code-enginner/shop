<?php
    use configReader\jsonReader;
    use functions\Model;

    require_once '../../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';
    require_once root.'functions/jdf.php';

    if (!is_login())
    {
        header('Location:'._base_url_2.'login.php');
        exit();
    }

    if (!isset($_GET['id']) || $_GET['id'] === '' || $_GET['id'] === NULL || intval($_GET['id']) == 0)
    {
        header('Location:'._base_url.'manage_pay_product.php');
        exit();
    }
    else
    {
        $id = htmlspecialchars(intval($_GET['id']));

        $data =
            [
                'fields' => [],
                'values' => [$id],
                'query' => 'SELECT `pay_download`.`p_available` FROM `pay_download` WHERE `pay_download`.`id` = ?;'
            ];
        $check_status =  Model::run() -> c_find($data);

        if ($check_status)
        {
            if ($check_status[0]['p_available'] == 1)
            {
                $data =
                    [
                        'fields' => [],
                        'values' => [$id],
                        'query' => 'UPDATE `pay_download` SET `pay_download`.`p_available` = 0 WHERE `pay_download`.`id` = ?;'
                    ];
                $result =  Model::run() -> c_find($data);
                if ($result)
                {
                    header('Location:'._base_url.'manage_pay_product.php');
                    exit();
                }
            }

            if ($check_status[0]['p_available'] == 0)
            {
                $data =
                    [
                        'fields' => [],
                        'values' => [$id],
                        'query' => 'UPDATE `pay_download` SET `pay_download`.`p_available` = 1 WHERE `pay_download`.`id` = ?;'
                    ];
                $result =  Model::run() -> c_find($data);
                if ($result)
                {
                    header('Location:'._base_url.'manage_pay_product.php');
                    exit();
                }
            }
        }
    }