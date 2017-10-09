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

    if(!isset($_GET['id']))
    {
        header('Location:'._base_url.'manage_pay_product.php');
        exit();
    }
    else
    {
        $id = htmlspecialchars(intval($_GET['id']));
    }

    $arguments =
        [
            'fields' => [],
            'values' => [$id],
            'query' => 'DELETE FROM `pay_download` WHERE `pay_download`.`id` = ?;'
        ];
    $result = Model::run()->c_find($arguments);
    if ($result)
    {
        header('Location:'._base_url.'manage_pay_product.php?delok=t');
        exit();
    }
    else
    {
        header('Location:'._base_url.'manage_pay_product.php?delok=f');
        exit();
    }