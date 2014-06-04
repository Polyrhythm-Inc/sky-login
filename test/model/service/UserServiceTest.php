<?php

namespace SkyLogin\test\model\service;

require_once dirname(__FILE__) . '/../../boot.php';

use SkyLogin\model\UserService;
use SkyLogin\model\User;
use SkyLogin\model\UserIdRelation;
use SkyLogin\model\UserEachPlatformAuthentication;
use SkyLogin\model\UserRole;
use SkyLogin\model\UserDevice;

use SkyLogin\exception\UnexpectedParameterException;
use SkyLogin\util\Utility;


class UserServiceTest extends \PHPUnit_Framework_TestCase {

  private function initialize(){
    User::connection()->query('TRUNCATE users');
    UserIdRelation::connection()->query('TRUNCATE user_id_relations');
    UserEachPlatformAuthentication::connection()->query('TRUNCATE user_each_platform_authentications');
    UserRole::connection()->query('TRUNCATE user_roles');
    UserDevice::connection()->query('TRUNCATE user_devices');
  }

  protected function setUp(){
    $this->initialize();
  }

  public function testRegister(){

    //正常系(addTransactions含む)
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

      $self = $this;

      $res = UserService::register($testData,
        array(
          function($me) use ($self) {
            $results = UserRole::add(array(
              'user_id' => $me['id'],
              'role_id' => 1
            ));
            $self->assertNotNull(UserRole::first($results->id));
          },
          function($me) use ($self) {
            $results = UserDevice::add(array(
              'user_id' => $me['id'],
              'device_id' => '25ab890e76d7801cda56abf8',
              'device_token' => '25ab890e76d7801cda56abf8',
              'os_type_id' => 1
            ));
            $self->assertNotNull(UserDevice::first($results['id']));
          }
        )
      );
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
    $this->initialize();
  }


}
