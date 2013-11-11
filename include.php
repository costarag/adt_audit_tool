<?php

error_reporting(E_ALL);

session_start();

ob_start();

require_once 'Database.class.php';
require_once 'MailUtil.class.php';
require_once 'MyAiesec.class.php';
require_once 'Util.class.php';

//require_once 'lib/class/BrSmarty.class.php';
//require_once 'lib/class/FileUtil.class.php';
//require_once 'lib/class/LoginUtil.class.php';
//require_once 'lib/class/MatchUtil.class.php';
//require_once 'lib/class/UserUtil.class.php';
//require_once 'lib/class/DateUtil.class.php';

$db = new Database();
