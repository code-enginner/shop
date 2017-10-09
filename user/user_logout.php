<?php
    require_once '../configs/configs.php';

    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_register_date']);
    unset($_SESSION['user_logged_date']);
    header('Location:'._base_url_2.'index.php');
    exit();