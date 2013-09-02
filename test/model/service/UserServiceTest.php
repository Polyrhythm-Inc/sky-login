<?php

namespace test\model\service;

require_once dirname(__FILE__) . '/../../boot.php';
require_once LIB_PATH . '/model/dao/User.php';
require_once LIB_PATH . '/model/dao/UserIdRelation.php';
require_once LIB_PATH . '/model/service/UserService.php';

use lib\model\service\UserService;
use lib\model\dao\User;
use lib\model\dao\UserIdRelation;
use lib\exception\UnexpectedParameterException;
use lib\util\Utility;

class UserServiceTest extends \PHPUnit_Framework_TestCase {

  protected function setUp(){
    User::connection()->query('TRUNCATE users');
    UserIdRelation::connection()->query('TRUNCATE user_id_relations');
  }

  public function testRegister(){

    $testData = array(
      'user_name' => 'test_user1',
      'email' => 'user3@sample.com',
      'password' => 'password',
      'role' => 2,
      'hash_id' => Utility::createHashId('test_user1')
    );

    $res = UserService::register($testData);

    var_dump($res);


  }

}