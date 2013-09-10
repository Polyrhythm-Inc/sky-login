<?php

/************** core php **************
*
*
*
*
****************************************/

date_default_timezone_set('Asia/Tokyo');

require_once SKYLOGIN_VENDOR_PATH . '/php-activerecord/ActiveRecord.php';
require_once SKYLOGIN_VENDOR_PATH . '/SplClassLoader.php';

//auto loader
$classLoader = new \SplClassLoader(null, SKYLOGIN_ROOT);
$classLoader->register();

function __boot_loader(){
  require_once SKYLOGIN_LIB_PATH . '/config/boot.php';
}


use SkyLogin\lib\configure\Configure;

/*************************************************
*
* Global settings
*
*************************************************/


//security salt
Configure::write('securitySalt', '76hba¥^-/:[peyu64@jhk*a1');

//sql trace and more...
Configure::write('debug', true);

Configure::write('debugLogPath', null);

Configure::write('enableUserhashId', false);

Configure::write('enableAutoLoginWithDeviceId', false);


/*************************************************
*
* Session login settings
*
*************************************************/

//email authentication
Configure::write('enableEmailAuth', true);

//name authentication
Configure::write('enableNameAuth', true);



/*************************************************
*
* Cookie authentication setting
*
*************************************************/

//allow cookie authentication?
Configure::write('enableAutoLoginWithCookie', false);

Configure::write('cookieAuthExpires', 86400);

Configure::write('cookieName', '__sltk__');

