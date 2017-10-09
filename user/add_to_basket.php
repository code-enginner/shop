<?php
    use configReader\jsonReader;
    use functions\Model;

    require_once '../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';


    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] === '' || $_SESSION['user_id'] === NULL)
    {
        header('Location:'._base_url.'index.php?lr=ne');
        exit();
    }
    else
    {
        $user_id = $_SESSION['user_id'];
    }

    if (isset($_GET['id']) && isset($_GET['n']) && isset($_GET['p']) && isset($_GET['pic']))
    {
        $values = [];

        $product_id = htmlspecialchars(intval($_GET['id']));
        $product_name = htmlspecialchars($_GET['n']);
        $price = htmlspecialchars($_GET['p']);
        $pic = htmlspecialchars($_GET['pic']);

        $values[] = $user_id;
        $values[] = $product_id;
        $values[] = $product_name;
        $values[] = $price;
        $values[] = $pic;

        $data_0 =
            [
                'fields' => [],
                'values' => [$product_id, $user_id],
                'query' => 'SELECT COUNT(`basket`.`product_id`) FROM `basket` WHERE (`basket`.`product_id` = ? AND `basket`.`user_id` = ?);',
            ];
        $is_new =  Model::run() -> c_find($data_0);

        if ($is_new[0]['COUNT(`basket`.`product_id`)'] == 0)
        {
            $data =
                [
                    'fields' => [],
                    'values' => $values,
                    'query' => 'INSERT INTO `basket` VALUES (NULL , ?, ?, ?, ?, ?, 1, 0);',
                ];
            $result =  Model::run() -> c_find($data);
            if ($result)
            {
                header('Location:'._base_url.'index.php?sb=ok');
                exit();
            }
            else
            {
                header('Location:'._base_url.'index.php?sb=w');
                exit();
            }
        }
        else
        {
            $data =
                [
                    'fields' => [],
                    'values' => [$product_id, $user_id],
                    'query' => 'UPDATE `basket` SET `number` = (`number` + 1) WHERE (`basket`.`product_id` = ? AND `basket`.`user_id` = ?);',
                ];
            $result =  Model::run() -> c_find($data);
            if ($result)
            {
                header('Location:'._base_url.'index.php?sb=ok');
                exit();
            }
            else
            {
                header('Location:'._base_url.'index.php?sb=w');
                exit();
            }
        }
    }
    elseif (!isset($_GET['id']) || $_GET['id'] === '' || $_GET['id'] === NULL)
    {
        header('Location:'._base_url.'index.php');
        exit();
    }

