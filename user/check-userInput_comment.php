<?php

    use configReader\jsonReader;
    use functions\Model;

    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';


    function check_user_comment($arguments)
    {
        $sysMSg = jsonReader::reade('systemMessage.json');

        $elm = [];
        $params = [];
        $base_captcha = NULL;
        $user_captcha = NULL;

        foreach ($arguments as $key => $value)
        {
            switch ($key)
            {
                case 'userName':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'نام';
                    }
                    else
                    {
                        $params[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'userLastName':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'نام خانوادگی';
                    }
                    else
                    {
                        $params[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'userEmail':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'ایمیل';
                    }
                    else
                    {
                        $params[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'userWebsite':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $params[] = 'بدون آدرس وب سایت';
                    }
                    else
                    {
                        $params[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'userRank':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'امتیاز';
                    }
                    else
                    {
                        $params[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'userComment':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'متن نظر';
                    }
                    else
                    {
                        $params[] = $arguments[$key];
                        $params[] = time();
                    }
                    break;
                case 'productId':
                    $params[] = htmlspecialchars($arguments[$key]);
                    break;
                case 'productName':
                    $params[] = htmlspecialchars($arguments[$key]);
                    $params[] = 0;
                    break;
                case 'user_id':
                    $params[] = htmlspecialchars($arguments[$key]);
                    break;
            }
        }

        if (count($elm) > 0)
        {
            $elm = implode(', ', $elm);
            $msg = $sysMSg['serverError'][5]['msg5'].$elm;
            return array
            (
                $msg,
                FALSE
            );
        }
        else
        {
            $data =
                [
                    'id' => 'null',
                    'values' => $params,
                    'tableName' => 'comment',
                    'allColumns' => TRUE,
                    'fields'=> []
                ];
            $result = Model::run() -> insert($data);
            return $result;
        }
    }