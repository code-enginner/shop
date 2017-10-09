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

    function product_dataUpdate_validation($arguments)
    {
        $sysMsg = jsonReader::reade('systemMessage.json');
        $data = [];
        $elem = [];
        $productPic = [];
        foreach ($arguments as $key => $value)
        {
            switch ($key)
            {
                case 'id':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        header('Location:'._base_url.'productManager.php?error=id_null'); // todo: create msg if $_GET['id_null'] isset;
                        exit();
                    }
                    else
                    {
                        $data[] = htmlspecialchars(intval($arguments[$key]));
                    }
                    break;
                case 'tblname_1':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        header('Location:'._base_url.'productManager.php?error=tblname_null'); // todo: create msg if $_GET['id_null'] isset;
                        exit();
                    }
                    else
                    {
                        $data['tblName'] = htmlspecialchars(($arguments[$key]));
                    }
                    break;
                case 'productName':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elem[$key] = 'نام محصول';
                    }
                    else
                    {
                        $data[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'productCatId':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elem[$key] = 'نام دسته';
                    }
                    else
                    {
                        $data[] = htmlspecialchars(intval($arguments[$key]));
                    }
                    break;
                case 'productAvailable':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elem[$key] = 'موجودیت';
                    }
                    else
                    {
                        $data[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'productPrice':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elem[$key] = 'قیمت محصول';
                    }
                    else
                    {
                        $data[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'productColor':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elem[$key] = 'رنگ محصول';
                    }
                    else
                    {
                        $data[] = htmlspecialchars($arguments[$key]);
                    }
                    break;
                case 'shortText':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elem[$key] = 'متن کوتاه پیش نمایش';
                    }
                    else
                    {
                        $data[] = ($arguments[$key]);
                    }
                    break;
                case 'productDescription':
                    if ($arguments[$key] === '' || $arguments[$key] === NULL)
                    {
                        $elem[$key] = 'توضیحات محصول';
                    }
                    else
                    {
                        $data[] = ($arguments[$key]);
                    }
                    break;
                case 'productPic':
                    $productPic = $arguments[$key];
                    break;
            }
        }

        if (($productPic['name'] === '' || $productPic['name'] === NULL || $productPic['tmp_name'] === '' || $productPic['tmp_name'] === NULL) && $productPic['size'] === 0)
        {
            // scope: update product with old productPic
            $data[] = $arguments['POST_currentPic'];
            // todo: create $arguments to pass to the Mode class;
//            $arguments =
//            [
//                'data' => $data,
//                'mathOp' => ['='],
//                'logicOp' => []
//            ];
            $result = Model::run() -> insertProduct($data);
            return $result;
        }
        else
        {
            // scope: update product with new productPic
            $accessSuffix = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
            try
            {
                if (!is_uploaded_file($productPic['tmp_name']))
                {
                    throw new Exception($sysMsg['serverError'][11]['msg11']);
                }

                if (!in_array($productPic['type'], $accessSuffix))
                {
                    throw new Exception($sysMsg['serverError'][7]['msg7']);
                }

                if ($productPic['size'] > 1.5*MB)
                {
                    throw new Exception($sysMsg['serverError'][8]['msg8']);
                }

                if ($productPic['error'] > 0)
                {
                    throw new Exception($sysMsg['serverError'][9]['msg9']);
                }
                else
                {
                    $perfixName = rand(0, time()).microtime();
                    $picName = $perfixName.$productPic['name'];
                    $finalPicPath = str_replace('\\', '/', root.'product_pic/'.$picName);
                }

                if (!move_uploaded_file($productPic['tmp_name'], $finalPicPath))
                {
                    throw new Exception($sysMsg['serverError'][9]['msg9']);
                }
                else
                {
                    $productPic = $picName;
                    $data[] = $productPic;
                    $result = Model::run() -> insertProduct($data);
                    if ($result === TRUE)
                    {
                        unlink(root.'admin/product/product_pic/'.$_SESSION['currentPic']);
                    }
                    return $result;
                }
            }
            catch (Exception $error)
            {
                return $error -> getMessage();
            }
        }
    }