<?php

    use configReader\jsonReader;
    use functions\Model;

    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] === '' || $_SESSION['user_id'] === NULL)
    {
        header('Location:'._base_url.'index.php?lr=ne');
        exit();
    }
    else
    {
        $user_id = $_SESSION['user_id'];
    }

    function check_user_sign_purchase($data)
    {
        global $user_id;
        $elm = [];
        $params = [];
        $sysMsg = jsonReader::reade('systemMessage.json');
        $arguments =
            [
                'fields' => [],
                'values' => [$user_id],
                'query' => 'SELECT * FROM `payline` LEFT JOIN `users` ON `payline`.`user_id` = `users`.`id` WHERE (`payline`.`user_id` = ?) LIMIT 1;'
            ];
        $base_info = Model::run() -> c_find($arguments);
        if ($base_info && count($base_info) > 0)
        {
            foreach ($data as $key => $value)
            {
                switch ($key)
                {
                    case 'full_name':
                        if ($data[$key] === '' || $data[$key] === NULL)
                        {
                            $elm[] = 'نام کاربری';
                        }
                        else
                        {
                            $params[] = $base_info[0]['user_id'];
                            $params[] = htmlspecialchars($data[$key]);
                        }
                        break;
                    case 'user_new_email':
                        if ($data[$key] === '' || $data[$key] === NULL)
                        {
                            $params[] = $base_info[0]['email'];
                            $params[] = time();
                        }
                        else
                        {
                            $params[] = htmlspecialchars($data[$key]);
                            $params[] = time();
                        }
                        break;
                }
            }
        }
        else
        {
            //todo: do some things if no any user found;
        }

        if (count($elm) > 0)
        {
            $elm = implode(', ', $elm);
            $msg = $sysMsg['serverError'][5]['msg5'].$elm;
            return $msg;
        }
        else
        {
            $arguments_3 =
                [
                    'fields' => [],
                    'values' => [$base_info[0]['user_id']],
                    'query' => 'SELECT `user_order_links`.`status`, `user_order_links`.`date` FROM `user_order_links` WHERE `user_order_links`.`user_id` = ? AND `user_order_links`.`status` = 0;'
                ];
            $check_register_order = Model::run() -> c_find($arguments_3);
            if ($check_register_order[0]['status'] != 0 && (time() - $check_register_order[0]['date'] >= 86400))
            {
                $argument =
                    [
                        'fields' => [],
                        'values' => [$user_id],
                        'query' => 'DELETE FROM `user_order_links` WHERE (`user_order_links`.`user_id` = ?);'
                    ];
                $delete_user_order = Model::run() -> c_find($argument);
                if ($delete_user_order)
                {
                    // the user already exists in `user_order_links` table.
                    header('Location:'._base_url.'basket_links_payment.php?page=0&ex=t');
                    exit();
                }
            }
            else
            {
                $arguments_3 =
                    [
                        'fields' => [],
                        'values' => $params,
                        'query' => 'INSERT INTO `user_order_links` VALUES (NULL, ?, ?, ?, ?, 0);'
                    ];
                $resister_order = Model::run() -> c_find($arguments_3);
                if ($resister_order)
                {
                    /*** send ***/
                    $api = 'test';
                    $amount = $_SESSION['all_price'];
                    $redirect = urlencode('http://localhost:8080/shop/user/basket_links_payment.php');
                    $factorNumber = random_int(0, 1000000).'/'.$_SERVER['REMOTE_ADDR'].'/'.$_SERVER['REMOTE_PORT'].'/'.time();

                    $result = send($api,$amount,$redirect,$factorNumber);
                    $result = json_decode($result);
                    if($result->status)
                    {
                        $go = "https://pay.ir/payment/gateway/$result->transId";
                        header("Location: $go");
                        exit();
                    }
                    else
                    {
                        echo $result->errorMessage;
                        return FALSE;
                    }
                }
            }
            return 'OK';
        }
    }