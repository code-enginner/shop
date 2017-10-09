<?php
    use configReader\jsonReader;
    use functions\Model;

    require_once '../../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';

    if (!is_login())
    {
        header('Location:'._base_url_2.'login.php');
        exit();
    }


    function product_data_validation($arguments)
    {
//        dump($arguments, TRUE);
        $sysMsg = jsonReader::reade('systemMessage.json');
        $elem = [];
        $params = [];
        $catName = [];

        for ($i = 0; $i < count($arguments); $i++)
        {
            if ($i === 0)
            {
                $catName = $arguments[$i];
            }

            if ($i === 1)
            {
                $data = array_slice($arguments[$i], 0, count($arguments[$i]) - 1);
                $params = [];
                foreach ($data as $key => $value)
                {
                    switch ($key)
                    {
                        case 'productName':
                            if ($data[$key] === '' || $data[$key] === NULL)
                            {
                                $elem[$key] = 'نام محصول';
                            }
                            else
                            {
                                $params[] = htmlspecialchars($data[$key]);
                            }
                            break;
                        case 'productCatId':
                            if ($data[$key] === '' || $data[$key] === NULL)
                            {
                                $elem[$key] = 'دسته محصول';
                            }
                            else
                            {
                                $params[] = htmlspecialchars(intval($data[$key]));
                                foreach ($catName as $k => $v)
                                {
                                    if ($k == $data[$key])
                                    {
                                        $params[] = htmlspecialchars($catName[$k]);
                                    }
                                }
                            }
                            break;
                        case 'productAvailable':
                            if ($data[$key] === '' || $data[$key] === NULL)
                            {
                                $elem[$key] = 'موجودیت محصول';
                            }
                            else
                            {
                                $params[] = htmlspecialchars($data[$key]);
                            }
                            break;
                        case 'productPrice':
                            if ($data[$key] === '' || $data[$key] === NULL)
                            {
                                $elem[$key] = 'قیمت محصول';
                            }
                            else
                            {
                                $params[] = htmlspecialchars($data[$key]);
                            }
                            break;
                        case 'productColor':
                            if ($data[$key] === '' || $data[$key] === NULL)
                            {
                                $elem[$key] = 'رنگ محصول';
                            }
                            else
                            {
                                $params[] = htmlspecialchars($data[$key]);
                            }
                            break;
                        case 'shortText':
                            if ($data[$key] === '' || $data[$key] === NULL)
                            {
                                $elem[$key] = 'متن کوتاه پیش نمایش';
                            }
                            else
                            {
//                                $params[] = htmlspecialchars($data[$key]);
                                $params[] = ($data[$key]);
                            }
                            break;
                        case 'productDescription':
                            if ($data[$key] === '' || $data[$key] === NULL)
                            {
                                $elem[$key] = 'توضیحات محصول';
                            }
                            else
                            {
                                $params[] = ($data[$key]);
                                $params[] = 0;
                                $params[] = 0;
                            }
                            break;
                    }
                }
                if(count($elem) > 0)
                {
                    $elem = implode(', ', $elem);
                    return $sysMsg['serverError'][5]['msg5']."<div class='alert alert-danger warning'><h5>$elem</h5></div>";
                }
            }

            if ($i === 2)
            {
                $productPic = isset($_FILES['productPic']) ? $_FILES['productPic'] : [];
                $accessSuffix = ['jpg', 'png', 'jpeg', 'gif'];
                try
                {
                    if ($productPic['name'] === '' || $productPic['name'] === NULL)
                    {
                        throw new Exception($sysMsg['serverError'][6]['msg6']);
                    }

                    if (!is_uploaded_file($productPic['tmp_name']))
                    {
                        throw new Exception($sysMsg['serverError'][11]['msg11']);
                    }

                    if ($productPic['size'] > 1.5*MB)
                    {
                        throw new Exception($sysMsg['serverError'][8]['msg8']);
                    }
                    else
                    {
                        $rightSuffix = NULL;
                        $pattern = '/\.([\w]+)/';
                        preg_match_all($pattern, $productPic['name'], $mathe);
                        $temp_name = $mathe[1];
                        $temp = $mathe[1];
                        $temp = array_slice($temp, -1, 1);
                        $temp = implode('', $temp);
                    }

                    if (!in_array($temp, $accessSuffix))
                    {
                        throw new Exception($sysMsg['serverError'][7]['msg7']);
                    }
                    else
                    {
                        $rightSuffix = '.'.$temp;
                    }

                    if ($productPic['error'] > 0)
                    {
                        throw new Exception($sysMsg['serverError'][9]['msg9']);
                    }

                    if (count($temp_name) > 1)
                    {
                        throw new Exception($sysMsg['serverError'][12]['msg12']);
                    }
                    else
                    {
                        $perfixName = rand(0, time()).microtime();
                        $picName = preg_replace('/\.([\w]+)/', '', $productPic['name']);
                        $picName = $perfixName.$picName;
                        $basicPicPath = $picName.$rightSuffix;
                        $finalPicPath = str_replace('\\', '/', root.'product_pic/'.$picName.$rightSuffix);
                    }

                    if (!move_uploaded_file($productPic['tmp_name'], $finalPicPath))
                    {
                        throw new Exception($sysMsg['serverError'][9]['msg9']);
                    }
                    else
                    {
                        if (isset($params) && count($params) > 0)
                        {
                            $tableName['tblName'] = 'product';
                            $params[] = $basicPicPath;
                            array_unshift($params,'NULL');
                            $params = $tableName + $params;

                            $result = Model::run() -> productInsert($params);
                            if ($result === TRUE)
                            {
                                return $sysMsg['serverSuccess'][5]['msg5'];
                            }
                            elseif ($result === FALSE)
                            {
                                unlink(root.'product_pic/'.$picName.$rightSuffix);
                                return $sysMsg['serverError'][13]['msg13'];
                            }
                        }
                    }
                }
                catch (Exception $error)
                {
                    return $error -> getMessage();
                }
            }
        }
        return NULL;
    }