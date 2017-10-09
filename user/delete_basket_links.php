<?php

    use configReader\jsonReader;
    use functions\Model;

    require_once '../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';
    require_once root.'functions/payFunctions.php';
    require_once root.'helperFunctions/sql_counter.php';

    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] === '' || $_SESSION['user_id'] === NULL)
    {
        header('Location:'._base_url_2.'by_download.php?lg=no');
        exit();
    }
    else
    {
        $user_id = $_SESSION['user_id'];
    }

    if (!isset($_GET['id']))
    {
        header('Location:'._base_url.'basket_links_payments.php');
        exit();
    }
    else
    {
        $p_id = htmlspecialchars(intval($_GET['id']));

        $arguments =
            [
                'fields' => [],
                'values' => [$p_id],
                'query' => 'DELETE FROM `payline` WHERE `payline`.`product_id` = ?'
            ];
        $result = Model::run() -> c_find($arguments);
        if ($result)
        {
            header('Location:'._base_url.'basket_links_payment.php');
            exit();
        }
        else
        {
            header('Location:'._base_url.'basket_links_payment.php');
            exit();
        }
    }