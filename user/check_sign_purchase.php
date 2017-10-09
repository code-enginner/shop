<?php

    use configReader\jsonReader;
    use functions\Model;


    function check_user_sign_purchase ($arguments)
    {
        if (!isset($_SESSION['user_id']))
        {
            header('Location:'._base_url_2.'index.php');
            exit();
        }
        $sysMsg = jsonReader::reade('systemMessage.json');

        $elm = [];
        $params = [];
        $final_phone = NULL;
        $final_email = NULL;
        $final_postal_code = NULL;
        $final_address = NULL;

        $user_id = $_SESSION['user_id'];

        $data =
            [
                'fields' => [],
                'values' => [$user_id],
                'query' => 'SELECT `email`, `cellphone`, `landline_phone`, `necessary_phone`, `postal_code`, `address`, `product_id`, `number`, `product_price`, `product_pic`, `product_name`
                            FROM `users` 
                            LEFT JOIN `basket` 
                            ON `users`.`id` = `basket`.`user_id` 
                            INNER JOIN `product` 
                            ON  `basket`.`product_id` = `product`.`id` 
                            WHERE `users`.`id` = ? 
                            ORDER BY `product_id`;'
            ];

        $result = Model::run() -> c_find($data);

        foreach ($result[0] as $key => $value)
        {
            switch ($key)
            {
                case 'cellphone':
                    $final_phone = $result[0][$key];
                    break;
                case 'email':
                    $final_email = $result[0][$key];
                    break;
                case 'postal_code':
                    $final_postal_code = $result[0][$key];
                    break;
                case 'address':
                    $final_address = $result[0][$key];
                    break;
            }
        }

        foreach ($arguments as $key => $value)
        {
            switch ($key)
            {
                case 'full_name':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'نام و نام خانوادگی';
                    }
                    else
                    {
                        $params[] = $user_id;
                        $params[] = strip_tags($arguments[$key]);
                    }
                    break;
                case 'user_new_phone':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $params[] = $final_phone;
                    }
                    else
                    {
                        $params[] = strip_tags($arguments[$key]);
                    }
                    break;
                case 'user_new_email':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $params[] = $final_email;
                    }
                    else
                    {
                        $params[] = strip_tags($arguments[$key]);
                    }
                    break;
                case 'order_type':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'نوع سفارش';
                    }
                    else
                    {
                        $params[] = strip_tags($arguments[$key]);
                    }
                    break;
                case 'user_new_postal_code':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $params[] = $final_postal_code;
                    }
                    else
                    {
                        $params[] = strip_tags($arguments[$key]);
                    }
                    break;
                case 'user_new_address':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $params[] = $final_address;
                    }
                    else
                    {
                        $params[] = strip_tags($arguments[$key]);
                    }
                    break;
                case 'user_points':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $params[] = 'بدون توضیحات';
                    }
                    else
                    {
                        $params[] = strip_tags($arguments[$key]);
                    }
                    break;
            }
        }

        if (count($elm) > 0)
        {
            $elm = implode(', ', $elm);
            echo $sysMsg['serverError'][5]['msg5'].$elm;
            return FALSE;
        }
        else
        {
            $params[] = jdate("l j F Y  \n  s : i : H");

            $data_2 =
                [
                    'fields' => [],
                    'values' => $params,
                    'query' => 'INSERT INTO `user_order` VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0);'
                ];
            $result_sign_purchase =  Model::run() -> c_find($data_2);
            if ($result_sign_purchase)
            {
                $TC = NULL;
                $data_3 =
                    [
                        'fields' => [],
                        'values' => [$user_id],
                        'query' => 'SELECT `order_id` FROM `user_order` WHERE `user_id` = ? ORDER BY `order_id` DESC;'
                    ];
                $result_3 =  Model::run() -> c_find($data_3);
                $TC = $result_3[0]['order_id'];

                $temp = [];
                $temp[] = $TC;
                $temp[] = $user_id;
                $data_4 =
                    [
                        'fields' => [],
                        'values' => $temp,
                        'query' => 'UPDATE `basket` SET `status` = ? WHERE `user_id` = ? ;'
                    ];
                $result_4 = Model::run() -> c_find($data_4);
                return array
                (
                    $TC,
                    TRUE
                );
            }
            else
            {
                return FALSE;
            }
        }





    }
