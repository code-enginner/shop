<?php
    use configReader\jsonReader;
    use functions\Model;



    function login_validation($arguments)
    {
        $sysMsg = jsonReader::reade('systemMessage.json');
        $elm = [];
        $params = [];
        $base_captcha = NULL;
        $user_captcha = NULL;
        $fatalError = FALSE;
        foreach ($arguments as $key => $value)
        {
            switch ($key)
            {
                case 'email':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'ایمیل';
                    }
                    else
                    {
                        $params[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'password':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'رمز عبور';
                    }
                    else
                    {
                        $params[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'secure_code':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'کد امنیتی';
                    }
                    else
                    {
                        $user_captcha = $arguments[$key];
                        if ($user_captcha != $_SESSION['c1'])
                        {
                            $fatalError = TRUE;
                        }
                        else
                        {
                            $fatalError = FALSE;
                        }
                    }
                    break;
            }
        }

        if (count($elm) > 0)
        {
            $elm = implode(', ', $elm);
            $msg = $sysMsg['serverError'][5]['msg5'].$elm;
            echo $msg;
            return FALSE;
        }
        else
        {
            if ($fatalError === TRUE)
            {
                echo $sysMsg['serverError'][19]['msg19'];
                return FALSE;
            }
            elseif ($fatalError === FALSE)
            {
                $data =
                    [
                        'fields' => [],
                        'values' => $params,
                        'query' => 'SELECT * FROM `users` WHERE `email` = ? AND `password` = ? LIMIT 1;'
                    ];
                $result =  Model::run() -> c_find($data);
                if ($result && count($result) > 0)
                {
                    $_SESSION['user_id'] = $result[0]['id'];
                    $_SESSION['user_name'] = $result[0]['name'].' '.$result[0]['lastName'];
                    $_SESSION['user_email'] = $result[0]['email'];
                    $_SESSION['user_register_date'] = $result[0]['register_date'];
                    $_SESSION['user_logged_date'] = $result[0]['last_logged_in'];

                    array_unshift($params, time());

                    $data_2 =
                        [
                            'fields' => [],
                            'values' => $params,
                            'query' => 'UPDATE `users` SET `users`.`last_logged_in` = ? WHERE (`email` = ? AND `password` = ?);'
                        ];
                    Model::run() -> c_find($data_2);

                    if ($result[0]['last_logged_in'] == 0)
                    {
                        header('Location:'._base_url.'user/userPanel.php?ui='.$result[0]['id'].'&fl=1');
                        exit();
                    }
                    else
                    {
                        header('Location:'._base_url.'user/userPanel.php?ui='.$result[0]['id']);
                        exit();
                    }
                }
                echo $sysMsg['serverError'][27]['msg27'];
                return FALSE;
            }
        }
        return NULL;
    }