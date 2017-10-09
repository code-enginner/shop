<?php
    use configReader\jsonReader;
    use functions\Model;

    require_once '../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';


    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] === '' || $_SESSION['user_id'] === NULL)
    {
        header('Location:'._base_url_2.'by_download.php?lg=no');
        exit();
    }
    else
    {
        $user_id = $_SESSION['user_id'];

        if (!isset($_GET['id']) || intval($_GET['id']) == 0)
        {
//            header('Location:'._base_url_2.'by_download.php');
//            exit();
        }
        else
        {
            $id = htmlspecialchars(intval($_GET['id']));
            $page = isset($_GET['page']) ? htmlspecialchars(intval($_GET['page'])) : 0;

            $product_name = NULL;
            $payline_params = [];

            $arguments =
                [
                    'fields' => [],
                    'values' => [$id],
                    'query' => 'SELECT * FROM `pay_download` WHERE `pay_download`.`id` = ?'
                ];
            $result = Model::run() -> c_find($arguments);
            if ($result)
            {
                $payline_params[] = $user_id;
                $payline_params[] = $result[0]['id'];
                $payline_params[] = $result[0]['p_name'];
                $payline_params[] = $result[0]['p_price'];

                $arguments_1 =
                    [
                        'fields' => [],
                        'values' => [$user_id, $id],
                        'query' => 'SELECT * FROM `payline` WHERE (`payline`.`user_id` = ? AND `payline`.`product_id` = ? AND `payline`.`status` = 0 AND `payline`.`tracking_code` = 0);'
                    ];
                $result_1 = Model::run() -> c_find($arguments_1);

                if (isset($result_1[0]) && count($result_1[0]) > 0)
                {
                    $arguments_2 =
                        [
                            'fields' => [],
                            'values' => [$id],
                            'query' => 'UPDATE `payline` SET `payline`.`number` = (`payline`.`number` + 1) , `payline`.`price` = (`payline`.`price` + '.$result_1[0]['price'].')  WHERE `payline`.`product_id` = ?;'
                        ];
                    $result_2 = Model::run() -> c_find($arguments_2);
                    if ($result_2)
                    {
                        header('Location:'._base_url_2.'by_download.php?add=t&page='.$page);
                        exit();
                    }
                    else
                    {
                        header('Location:'._base_url.'by_download.php?erradd=t&page='.$page);
                        exit();
                    }
                }

                if (!isset($result_1[0]) || count($result_1[0]) == 0)
                {
                    $arguments_2 =
                        [
                            'fields' => [],
                            'values' => $payline_params,
                            'query' => 'INSERT INTO `payline` VALUES (NULL, ?, ?, ?, ?, 1, 0, 0);'
                        ];
                    $result_2 = Model::run() -> c_find($arguments_2);
                    if ($result_2)
                    {
                        header('Location:'._base_url_2.'by_download.php?add=t&page='.$page);
                        exit();
                    }
                    else
                    {
                        header('Location:'._base_url.'by_download.php?erradd=t&page='.$page);
                        exit();
                    }
                }
            }
        }
    }