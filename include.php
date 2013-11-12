<?php

error_reporting(E_ALL);

session_start();

ob_start();

require_once 'db/Database.class.php';
require_once 'mail/MailUtil.class.php';
require_once 'myaiesec/MyAiesec.class.php';
require_once 'util/Util.class.php';

$db = new Database();
