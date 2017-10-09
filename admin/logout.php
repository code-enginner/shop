<?php

    require_once '../configs/configs.php';
    require_once root.'/helperFunctions/functions.php';

    unset($_SESSION['lName']);
    unset($_SESSION['fName']);
    unset($_SESSION['email']);
    header('Location:'._base_url_2.'index.php');
    exit();
