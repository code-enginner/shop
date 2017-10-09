<?php

    use functions\Model;

    function numberCounter ($data)
    {
        $num_pr = 0;
        $values =
            [
                'fields' => [],
                'values' => [$data],
                'query' => 'SELECT `basket`.`number` FROM `basket` WHERE `basket`.`status` = ?;'
            ];
        $result = Model::run() -> c_find($values);
        for ($i = 0; $i < count($result); $i++)
        {
            $num_pr += intval($result[$i]['number']);
        }
        return $num_pr;
    }



    function numberCounter_2 ($data, $userId)
    {
        $num_pr = 0;
        $values =
            [
                'fields' => [],
                'values' => [$data, $userId],
                'query' => 'SELECT `payline`.`number` FROM `payline` WHERE (`payline`.`product_id` = ? AND `payline`.`user_id` = ? AND `payline`.`status` = 0 AND `payline`.`tracking_code` = 0);'
            ];
        $result = Model::run() -> c_find($values);
        for ($i = 0; $i < count($result); $i++)
        {
            $num_pr += intval($result[$i]['number']);
        }
        return $num_pr;
    }



    function priceCounter ($data)
    {
        $final_pr = 0;
        $values =
            [
                'fields' => [],
                'values' => [$data],
                'query' => 'SELECT `basket`.`product_price` FROM `basket` WHERE `basket`.`status` = ?;'
            ];
        $result = Model::run() -> c_find($values);
        for ($i = 0; $i < count($result); $i++)
        {
            $final_pr += intval($result[$i]['product_price']);
        }
        return $final_pr;
    }




    function priceCounter_2 ($data, $userId)
    {
        $final_pr = 0;
        $values =
            [
                'fields' => [],
                'values' => [$data, $userId],
                'query' => 'SELECT `payline`.`price` FROM `payline` WHERE (`payline`.`product_id` = ? AND `payline`.`user_id` = ? AND `payline`.`status` = 0 AND `payline`.`tracking_code` = 0);'
            ];
        $result = Model::run() -> c_find($values);
        for ($i = 0; $i < count($result); $i++)
        {
            $final_pr += intval($result[$i]['price']);
        }
        return $final_pr;
    }




    function getProductName ($data)
    {
        $product_id = [];
        $values =
            [
                'fields' => [],
                'values' => [$data],
                'query' => 'SELECT `basket`.`product_id` FROM `basket` WHERE `basket`.`status` = ?;'
            ];
        $result = Model::run() -> c_find($values);
        for ($i = 0; $i < count($result); $i++)
        {
            $product_id[] = $result[$i]['product_id'];
        }

        if (isset($product_id))
        {
            $product_names = NULL;
            for ($i = 0; $i < count($product_id); $i++)
            {
                $values_2 =
                    [
                        'fields' => [],
                        'values' => [$product_id[$i]],
                        'query' => 'SELECT `product`.`product_name` FROM `product` WHERE `product`.`id` = ?;'
                    ];
                $result_2 = Model::run() -> c_find($values_2);
                $product_names .= ', '.$result_2[0]['product_name'].' ';
                $product_names = ltrim($product_names, ', ');
            }
            return $product_names;
        }
        else
        {
            return '--';
        }
    }

    function getUserName($data)
    {
        $arguments =
            [
                'fields' => [],
                'values' => [$data],
                'query' => 'SELECT `users`.`name`, `users`.`lastName` FROM `users` WHERE (`users`.`id` = ?);'
            ];
        $result = Model::run() -> c_find($arguments);
        if ($result)
        {
            $fullName = $result[0]['name'].' '.$result[0]['lastName'];
            return $fullName;
        }
        return '<i>پیدا نشد!</i>';
    }