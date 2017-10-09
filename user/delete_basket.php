<?php

    use configReader\jsonReader;
    use functions\Model;

    require_once '../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';


    if (isset($_GET['pi']))
    {
        $stuff_id = htmlentities(intval($_GET['pi']));

        $data =
            [
                'fields' => [],
                'values' => [$stuff_id],
                'query' => 'DELETE FROM `basket` WHERE `product_id` = ?;'
            ];

        $result = Model::run() -> c_find($data);
        if ($result)
        {
            header('Location:'._base_url.'userPanel.php?ui='.$_SESSION['user_id'].'&b=act');
            exit();
        }
        else
        {
            header('Location:'._base_url.'userPanel.php?ui='.$_SESSION['user_id'].'&b=act');
            exit();
        }
    }
    else
    {
        header('Location:'._base_url.'userPanel.php');
        exit();
    }