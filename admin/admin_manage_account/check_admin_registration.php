<?php
    use configReader\jsonReader;
    use functions\Model;

    function check_values($arguments)
    {
        $sysMsg = jsonReader::reade('systemMessage.json');
        $elm = [];
        $param = [];

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
                        $param[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'lastname':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'نام خانوادگی';
                    }
                    else
                    {
                        $param[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'email':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'ایمیل';
                    }
                    else
                    {
                        $param[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'username':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'نام کاربری';
                    }
                    else
                    {
                        $param[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'password':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elm[] = 'رمز عبور';
                    }
                    else
                    {
                        $param[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
            }
        }

        if (count($elm) > 0)
        {
            $elm = implode(', ', $elm);
            echo $msg = $sysMsg['serverError'][5]['msg5'].$elm;  // todo: create msg if some fields are empty.
            return FALSE;
        }
        else {

            $temp_check[] = $param[2];
            $temp_check[] = $param[3];
            $arguments_2 =
                [
                    'fields' => [],
                    'values' => $temp_check,
                    'query' => 'SELECT COUNT(*) FROM `admin` WHERE (`admin`.`email` = ? OR `admin`.`username` = ?) LIMIT 1;'
                ];
            $result_0 = Model::run()->c_find($arguments_2);
            if ($result_0)
            {
                if ($result_0[0]['COUNT(*)'] == 0)
                {
                    $arguments_1 =
                        [
                            'fields' => [],
                            'values' => $param,
                            'query' => 'INSERT INTO `admin` VALUES (NULL, ?, ?, ?, ?, ?);'
                        ];
                    $result_1 = Model::run()->c_find($arguments_1);
                    if ($result_1)
                    {
                        echo $sysMsg['serverSuccess'][16]['msg16'];
                        return TRUE;
                    }
                }
                else
                {
                    echo $sysMsg['serverError'][31]['msg31'];
                    return FALSE;
                }
            }
        }
        return NULL;
    }

