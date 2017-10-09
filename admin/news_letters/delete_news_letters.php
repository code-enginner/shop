<?php
    use configReader\jsonReader;
    use functions\Model;

    require_once '../../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'helperFunctions/sql_counter.php';
    require_once root.'vendor/autoload.php';


    if (!isset($_GET['id']) || intval($_GET['id']) == 0)
    {
        header('Location:'._base_url_2.'panel.php');
        exit();
    }
    else
    {
        $sysMsg = jsonReader::reade('systemMessage.json');
        $id = htmlspecialchars(intval($_GET['id']));

        $data =
            [
                'fields' => [],
                'values' => [$id],
                'query' => 'DELETE FROM `news_letters` WHERE `news_letters`.`id` = ?;'
            ];
        $result =  Model::run() -> c_find($data);
        if ($result)
        {
            header('Location:'._base_url.'manage_news_letters.php');
            exit();
        }
    }

