<?php

    use configReader\jsonReader;
    use functions\Model;

    function check_user_input_register($arguments)
    {
        $sysMSg = jsonReader::reade('systemMessage.json');
        $elm = [];
        $param = [];
        $tempCaptcha = NULL;
        foreach ($arguments as $key => $value)
        {
            switch ($key)
            {
                case 'user_name':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'نام';
                    }
                    else
                    {
                        $param[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'user_family':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'نام خانوادگی';
                    }
                    else
                    {
                        $param[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'user_email':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'ایمیل';
                    }
                    else
                    {
                        $param[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'user_password':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'رمز عبور';
                    }
                    else
                    {
                        $param[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'R_user_password':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'تکرار رمز عبور';
                    }
                    else
                    {
                        $param[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'user_cellphone':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'شماره تلفن همراه';
                    }
                    else
                    {
                        $param[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'user_landline_phone':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'شماره تلفن ثابت';
                    }
                    else
                    {
                        $param[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'user_necessary_phone':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'شماره تلفن ضروری';
                    }
                    else
                    {
                        $param[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'user_postal_code':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'کد پستی';
                    }
                    else
                    {
                        $param[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'user_address':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'آدرس';
                    }
                    else
                    {
                        $param[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'secure_code':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'کد امنیتی';
                    }
                    else
                    {
                        $param[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'register_time':
                    $param[] = htmlspecialchars($arguments[$key]);
                    break;
            }
        }

        if (count($elm) > 0)
        {
            $elm = implode(', ', $elm);
            return $msg = $sysMSg['serverError'][5]['msg5'].$elm;  // todo: create msg if some fields are empty.
        }
        else
        {
            $email = NULL;
            $R_email = NULL;
            $password = NULL;
            $R_password = NULL;
            $user_captcha = NULL;

            foreach ($param as $index => $value)
            {
                if ($index === 3)
                {
                    $password = $param[$index];
                }
                if ($index === 4)
                {
                    $R_password = $param[$index];
                }
                if ($index === 10)
                {
                    $user_captcha = $param[$index];
                }
            }

            if ($password !== $R_password)
            {
                $fatal_error[] = $sysMSg['serverError'][18]['msg18'];
            }
            if ($user_captcha != $_SESSION['c2'])
            {
                $fatal_error[] = $sysMSg['serverError'][19]['msg19'];
            }

            if (isset($fatal_error) && count($fatal_error) > 0)
            {
                $fatal_error = implode(', ', $fatal_error);
                echo $msg = ''.$fatal_error; // todo: create msg if email or password are not some;
                return FALSE;
            }
            else
            {
                $arguments_1 =
                    [
                        'fields' => [],
                        'values' => [$param[2]],
                        'query' => 'SELECT COUNT(*) FROM `users` WHERE `email` = ? LIMIT 1;'
                    ];
                $result_1 = Model::run() -> c_find($arguments_1);

                if ($result_1 && $result_1[0]['COUNT(*)'] > 0)
                {
                    echo $sysMSg['serverError'][16]['msg16'];
                    return FALSE;
                }
                else
                {
                    unset($param[4]);
                    unset($param[10]);
                    $param[] = 0;
                    $arguments_2 =
                        [
                            'id' => 'null',
                            'values' => $param,
                            'tableName' => 'users',
                            'allColumns' => TRUE,
                            'fields'=> []
                        ];
                    $result_2 = Model::run() -> insert($arguments_2);
                    return $result_2;
                }
            }
        }
    }

