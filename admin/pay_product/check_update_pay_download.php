<?php
    use configReader\jsonReader;
    use functions\Model;

    if (!is_login())
    {
        header('Location:'._base_url_2.'login.php');
        exit();
    }

    if (!isset($_GET['id']))
    {
        header('Location:'._base_url.'manage_pay_product.php');
        exit();
    }
    else
    {
        $id = htmlspecialchars(intval($_GET['id']));

    }

    function check_update_values($data)
    {
        global $id;
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
            $params[] = $id;
            $arguments =
                [
                    'fields' => [],
                    'values' => $params,
                    'query' => 'UPDATE `pay_download` SET `pay_download`.`p_name` = ?, `pay_download`.`download_link` = ?, `pay_download`.`p_price` = ?, `pay_download`.`p_short_text` = ?, `pay_download`.`p_long_text` = ? WHERE `pay_download`.`id` = ?;'
                ];
            $result = Model::run()->c_find($arguments);
            if ($result)
            {
                echo $sysMsg['serverSuccess'][11]['msg11'];
                header('refresh:1;url='._base_url.'manage_pay_product.php');
                exit();
            }
        }
        return NULL;
    }


