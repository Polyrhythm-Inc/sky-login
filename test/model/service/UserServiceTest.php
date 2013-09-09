<?php

namespace SkyLogin\test\model\service;

require_once dirname(__FILE__) . '/../../boot.php';

use SkyLogin\lib\model\service\UserService;
use SkyLogin\lib\model\dao\User;
use SkyLogin\lib\model\dao\UserIdRelation;
use SkyLogin\lib\model\dao\UserEachPlatformAuthentication;
use SkyLogin\lib\exception\UnexpectedParameterException;
use SkyLogin\lib\util\Utility;

class UserServiceTest extends \PHPUnit_Framework_TestCase {

  protected function setUp(){
    User::connection()->query('TRUNCATE users');
    UserIdRelation::connection()->query('TRUNCATE user_id_relations');
    UserEachPlatformAuthentication::connection()->query('TRUNCATE user_each_platform_authentications');
  }

  public function testRegister(){

    //正常系
    {
      $testData = array(
        'user_name' => 'test_user1',
        'email' => 'test_user1@sample.com',
        'password' => 'password',
        'role' => 2,
        'hash_id' => Utility::createHashId('test_user1'),
        'platform_id' => 1,
        'platform_user_id' => 'hogehoge',
        'auth_token' => sha1('hogehoge'),
        'expires' => '1988-07-22 00:00:00'
      );

      $res = UserService::register($testData);
      $this->assertNotNull($res);

    }


    //異常系(引数がnull)
    {
      $testData = null;

      try{
        $res = UserService::register($testData);
      }catch(\Exception $e){
        $this->assertEquals($e, new UnexpectedParameterException);
      }
      
    }


    //異常系(hashidが不正な値)
    {
      $testData = array(
        'user_name' => 'test_user1',
        'email' => 'user3@sample.com',
        'password' => 'password',
        'role' => 2,
        'hash_id' => "' OR1=1 --",
        'platform_id' => 1,
        'platform_user_id' => 'hogehoge',
        'auth_token' => sha1('hogehoge'),
        'expires' => '1988-07-22 00:00:00'        
      );

      try{
        $res = UserService::register($testData);
      }catch(\Exception $e){
        $this->assertEquals(get_class($e), "ActiveRecord\DatabaseException");
      }
      
    }

  }

  protected function tearDown(){
    User::connection()->query('TRUNCATE users');
    UserIdRelation::connection()->query('TRUNCATE user_id_relations');
    UserEachPlatformAuthentication::connection()->query('TRUNCATE user_each_platform_authentications');
  }


}