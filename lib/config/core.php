<?php

/************** core php **************
*
*
*
*
****************************************/
function __boot_loader(){
  require_once SKYLOGIN_LIB_PATH . '/config/boot.php';
}

use SkyLogin\Configure;

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

Configure::write('enableContainUserRoleData', false);

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
