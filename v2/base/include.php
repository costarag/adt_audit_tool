<?php

error_reporting(E_ALL);

// session_set_cookie_params (60 * 60 * 5);
session_start();
require_once 'util/Database.class.php';
require_once 'util/MailUtil.class.php';
//require_once 'lib/class/BrSmarty.class.php';
//require_once 'lib/class/FileUtil.class.php';
//require_once 'lib/class/LoginUtil.class.php';
//require_once 'lib/class/MatchUtil.class.php';
//require_once 'lib/class/UserUtil.class.php';
//require_once 'lib/class/DateUtil.class.php';

$db = new Database();
$db->connect();
