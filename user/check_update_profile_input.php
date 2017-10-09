<?php
    use configReader\jsonReader;
    use functions\Model;

    require_once '../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'functions/jdf.php';
    require_once root.'vendor/autoload.php';

    function check_user_update_profile($arguments)
    {
        $sysMsg = jsonReader::reade('systemMessage.json');
        $elm = [];
        $params = [];
        foreach ($arguments as $key => $value)
        {
            switch ($key)
            {
                case 'name':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'نام';
                    }
                    else
                    {
                        $params[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'lastname':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'نام خانوادگی';
                    }
                    else
                    {
                        $params[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
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
                case 'cellphone':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'شماره همراه';
                    }
                    else
                    {
                        $params[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'landline_phone':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'شماره ثابت';
                    }
                    else
                    {
                        $params[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'necessary_phone':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'شمار تماس ضروری';
                    }
                    else
                    {
                        $params[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'postal_code':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'کد پستی';
                    }
                    else
                    {
                        $params[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'address':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'آدرس';
                    }
                    else
                    {
                        $params[] = htmlspecialchars($arguments[$key]);
                        $params[] = $arguments['user_id'];
                    }
                    break;
            }
        }

        if (count($elm) > 0)
        {
            $elm = implode(', ', $elm);
            return $sysMsg['serverError'][5]['msg5'].$elm;
        }
        else
        {
            $arguments =
                [
                    'fields' => [],
                    'values' => $params,
                    'query' => 'UPDATE `users` SET `users`.`name` = ?, `users`.`lastName` = ?, `users`.`email` = ?, `users`.`cellphone` = ?, `users`.`landline_phone` = ?, `users`.`necessary_phone` = ?, `users`.`postal_code` = ?, `users`.`address` = ? WHERE (`users`.`id`  = ?);'
                ];
            $result = Model::run() -> c_find($arguments);
            if ($result)
            {
                return $sysMsg['serverSuccess'][11]['msg11'];
            }
            else
            {
                return $sysMsg['serverError'][32]['msg32'];
            }
        }
    }