<?php
    use configReader\jsonReader;
    use functions\Model;


    if (!is_login())
    {
        header('Location:'._base_url_2.'login.php');
        exit();
    }

    function check_inputs($argument)
    {
        $sysMsg = jsonReader::reade('systemMessage.json');
        if ($argument['news_text'] === '' || $argument['news_text'] === NULL)
        {
            echo $sysMsg['serverError'][5]['msg5']. 'متن خبر';
            return FALSE;
        }
        else
        {
            $news_text = htmlspecialchars($_POST['news_text']);
            $data =
                [
                    'fields' => [],
                    'values' => [$news_text],
                    'query' => 'INSERT INTO `news` VALUES (NULL, ?, 0) ;'
                ];
            $result =  Model::run() -> c_find($data);
            if ($result)
            {
                echo $sysMsg['serverSuccess'][12]['msg12'];
                return TRUE;
            }
        }
        return NULL;
    }