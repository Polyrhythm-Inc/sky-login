<?php

namespace SkyLogin;

//module dependencies
require_once dirname(__FILE__)    . "/common.php";
require_once SKYLOGIN_VENDOR_PATH . '/php-activerecord/ActiveRecord.php';
require_once SKYLOGIN_VENDOR_PATH . '/SplClassLoader.php';

//auto loader
$classLoader = new \SplClassLoader(null, __DIR__);
$classLoader->register();

require_once SKYLOGIN_LIB_PATH . "/exports.php";