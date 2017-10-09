<?php
    use configReader\jsonReader;
    use functions\Model;

    if (!is_login())
    {
        header('Location:'._base_url_2.'login.php');
        exit();
    }

    function check_values($data)
    {
        $sysMsg = jsonReader::reade('systemMessage.json');
        $elm = [];
        $params = [];
        foreach ($data as $key => $value)
        {
            switch ($key)
            {
                case 'name':
                    if ($data[$key] === '' || $data[$key] === NULL)
                    {
                        $elm[] = 'نام محصول';
                    }
                    else
                    {
                        $params[] = htmlspecialchars($data[$key]);
                    }
                    break;
                case 'download_link':
                    if ($data[$key] === '' || $data[$key] === NULL)
                    {
                        $elm[] = 'لینک دانلود محصول';
                    }
                    else
                    {
                        $params[] = htmlspecialchars($data[$key]);
                    }
                    break;
                case 'price':
                    if ($data[$key] === '' || $data[$key] === NULL)
                    {
                        $elm[] = 'قیمت محصول';
                    }
                    else
                    {
                        $params[] = htmlspecialchars($data[$key]);
                    }
                    break;
                case 'short_text':
                    if ($data[$key] === '' || $data[$key] === NULL)
                    {
                        $elm[] = 'توضیحات کوتاه محصول';
                    }
                    else
                    {
                        $params[] = htmlspecialchars($data[$key]);
                    }
                    break;
                case 'long_text':
                    if ($data[$key] === '' || $data[$key] === NULL)
                    {
                        $elm[] = 'توضیحات کامل محصول';
                    }
                    else
                    {
                        $params[] = $data[$key];
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
            $arguments =
                [
                    'fields' => [],
                    'values' => $params,
                    'query' => 'INSERT INTO `pay_download` VALUES (NULL, ?, ?, ?, ?, ?, 1, 0);'
                ];
            $result = Model::run() -> c_find($arguments);
            if ($result)
            {
                echo $sysMsg['serverSuccess'][4]['msg4'];
                return TRUE;
            }
        }
        return NULL;
    }