<?php

    use configReader\jsonReader;
    use functions\Model;

    function check_email($data)
    {
        $sysMsg = jsonReader::reade('systemMessage.json');
        $email = htmlspecialchars($data['register_me']);

        $arguments =
            [
                'fields' => [],
                'values' => [$email],
                'query' => 'SELECT COUNT(`email`) FROM `news_letters` WHERE `news_letters`.`email` = ? LIMIT 1;'
            ];
        $result = Model::run()->c_find($arguments);
        if ($result)
        {
            if ($result[0]['COUNT(`email`)'] == 0)
            {
                $arguments_0 =
                    [
                        'fields' => [],
                        'values' => [$email],
                        'query' => 'INSERT INTO `news_letters` VALUES (NULL, ?, 1);'
                    ];
                $result_0 = Model::run()->c_find($arguments_0);
                if ($result_0)
                {
                    echo $sysMsg['serverSuccess'][15]['msg15'];
                    return TRUE;
                }
            }
            else
            {
                echo $sysMsg['serverError'][30]['msg30'];
                return FALSE;
            }
        }
        return NULL;
    }