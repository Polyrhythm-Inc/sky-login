<?php

namespace SkyLogin;

//module dependencies
require_once dirname(__FILE__) . '/vendors/php-activerecord/ActiveRecord.php';
require_once dirname(__FILE__) . "/vendors/SplClassLoader.php";

//auto loader
$classLoader = new \SplClassLoader(null, __DIR__);
$classLoader->register();

require_once dirname(__FILE__) . "/lib/exports.php";