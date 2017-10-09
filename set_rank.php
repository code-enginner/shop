<?php
    use configReader\jsonReader;
    use functions\Model;

    require_once 'configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';


    if (isset($_GET['plus']) && $_GET['plus'] == 1)
    {
        goto A;
    }

    if (isset($_GET['mines']) && $_GET['mines'] == 1)
    {
        goto B;
    }



    /*
     * If User Like Product
     *
     * */
    A:
    {
        if ( ((isset($_GET['plus']) && $_GET['plus'] == 1) ) && isset($_GET['pr_i']) && isset($_GET['id']) && isset($_GET['tblname']))
        {
            $product_id = htmlspecialchars(intval($_GET['pr_i']));
            $data =
                [
                    'fields' => [],
                    'values' => [$product_id],
                    'query' => 'UPDATE `product` SET `rankPlus` = (`rankPlus` + 1) WHERE `id` = ?;'
                ];
            $result =  Model::run() -> c_find($data);
            if ($result)
            {
                header('Location:'._base_url.'showProduct.php?id='.$product_id.'&tblname=product&plusOK=1#'.$_GET['id']);
                exit();
            }
        }
        else
        {
            header('Location:'._base_url.'index.php');
            exit();
        }
    }





    /*
     * If User Unlike Product
     *
     * */
    B:
    {
        if ( ((isset($_GET['mines']) && $_GET['mines'] == 1) ) && isset($_GET['pr_i']) && isset($_GET['id']) && isset($_GET['tblname']))
        {

            $product_id = htmlspecialchars(intval($_GET['pr_i']));
            $data =
                [
                    'fields' => [],
                    'values' => [$product_id],
                    'query' => 'UPDATE `product` SET `rankMines` = (`rankMines` - 1) WHERE `id` = ?;'
                ];
            $result =  Model::run() -> c_find($data);
            if ($result)
            {
                header('Location:'._base_url.'showProduct.php?id='.$product_id.'&tblname=product&minesOK=1#'.$_GET['id']);
                exit();
            }
        }
        else
        {
            header('Location:'._base_url.'index.php');
            exit();
        }
    }