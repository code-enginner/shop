<?php

    use functions\Model;

    require_once '../../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'vendor/autoload.php';

    if (!is_login())
    {
        header('Location:'._base_url_2.'login.php');
        exit();
    }

    // todo: create modal before deleting;


    if (!isset($_GET['id']) || !isset($_GET['tname']))
    {
        $_SESSION['lName'] = '';
        $_SESSION['fName'] = '';
        $_SESSION['email'] = '';
        unset($_SESSION['lName']);
        unset($_SESSION['fName']);
        unset($_SESSION['email']);
        header('Location:'._base_url_2.'panel.php');
        exit();
    }

    try
    {
        if (  ($_GET['id'] === '' || $_GET['id'] === NULL || !is_numeric($_GET['id']))   ||   ($_GET['tname'] === '' || $_GET['tname'] === NULL || !is_string($_GET['tname']))  )
        {
            throw new Exception(); //todo: create msg if $_GET['id'] & $_GET['tname'] are empty
        }
        else
        {
            $id = NULL;
            $tableName = NULL;
            foreach ($_GET as $key => $value)
            {
                switch ($key)
                {
                    case 'id':
                        $id = htmlspecialchars(intval($_GET[$key]));
                        break;
                    case 'tname':
                        $tableName = strtolower(htmlspecialchars($_GET[$key]));
                        break;
                }
            }
            $arguments =
                [
                    'conditions' => ['id' => $id],
                    'tableName' => $tableName,
                    'mathOp' => ['='],
                    'logicOp' => [],
                ];

            if ($result = Model::run() -> delete($arguments))
            {
                header('Location:'._base_url_2.'cat/catManage.php?delok=1');
                exit();
            }
            else
            {
                echo $result;
            }
        }
    }
    catch (Exception $error)
    {
        exit($error -> getMessage());
    }