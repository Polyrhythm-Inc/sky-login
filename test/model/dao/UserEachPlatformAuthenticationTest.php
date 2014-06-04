<?php

namespace SkyLogin\test\model\dao;

require_once dirname(__FILE__) . '/../../boot.php';

use SkyLogin\exception\UnexpectedParameterException;
use SkyLogin\util\Utility;
use SkyLogin\model\UserEachPlatformAuthentication;

class UserEachPlatformAuthenticationTest extends \PHPUnit_Framework_TestCase {


  protected function setUp(){
    $table = UserEachPlatformAuthentication::table();
    UserEachPlatformAuthentication::connection()->query('TRUNCATE ' . $table->table);
  }

  public function testAdd(){

    //正常系
    {
      $testData = array(
        'user_id' => 1,
        'platform_id' => 1,
        'platform_user_id' => 1,
        'auth_token' => 'hogehogehogehogehoge',
        'expires' => date('Y-m-d H:i:s', time() + 86400)
      );

      $res = UserEachPlatformAuthentication::add($testData);
      $this->assertNotNull(UserEachPlatformAuthentication::first($res->id));
    }


    //異常系（引数がnull）
    {
      $testData = null;

      try{
        $res = UserEachPlatformAuthentication::add($testData);
      }catch(\Exception $e){
        $this->assertEquals($e, new \SkyLogin\exception\UnexpectedParameterException);
      }
    }
  }

  public function testGetByPlatformIdAndAuthToken(){

    //正常系
    {
      $pid = 2;
      $token = sha1('testtesttesttesttest');

      $testData = array(
        'user_id' => 1,
        'platform_id' => $pid,
        'platform_user_id' => 2,
        'auth_token' => $token,
        'expires' => '1988-07-22 00:00:00',
        'created' => '1988-07-22 00:00:00',
        'modified' => '1988-07-22 00:00:00',
      );

      $expected = array(
        "id" => 1,
        "user_id" => 1,
        "platform_id" => $pid,
        "platform_user_id" => 2,
        "auth_token" => $token,
        "expires" => "1988-07-22T00:00:00+0900",
        "created" => "1988-07-22T00:00:00+0900",
        "modified" => "1988-07-22T00:00:00+0900"
      );



      UserEachPlatformAuthentication::add($testData);
      $res = UserEachPlatformAuthentication::getByPlatformIdAndAuthToken($pid, $token);
      $this->assertEquals($res->to_array(), $expected);
    }

    //異常系(引数がnull)
    {
      $pid = null;
      $token = null;

      $testData = array(
        'user_id' => 1,
        'platform_id' => 1,
        'platform_user_id' => 2,
        'auth_token' => sha1('hogehoge'),
        'expires' => '1988-07-22 00:00:00',
        'created' => '1988-07-22 00:00:00',
        'modified' => '1988-07-22 00:00:00',
      );

      UserEachPlatformAuthentication::add($testData);

      try{
        $res = UserEachPlatformAuthentication::getByPlatformIdAndAuthToken($pid, $token);
      }catch(\Exception $e){
        $this->assertEquals($e, new \SkyLogin\exception\UnexpectedParameterException);
      }
    }
  }

  public function testUpdateByPlatformIdAndUserId(){

    //正常系
    {
      $testData = array(
        'user_id' => 1,
        'platform_id' => 1,
        'platform_user_id' => 2,
        'auth_token' => sha1('hogehoge'),
        'expires' => '1988-07-22 00:00:00',
        'created' => '1988-07-22 00:00:00',
        'modified' => '1988-07-22 00:00:00',
      );

      UserEachPlatformAuthentication::add($testData);

      $params = array(
        'expires' => '1988-07-22 00:00:00',
        'auth_token' => sha1('hogehogehogehoge')
      );

      $res = UserEachPlatformAuthentication::updateByPlatformIdAndUserId($params, 1, 1);
      $this->assertTrue($res);
    }


    //異常系(引数がnull)
    {
      $testData = array(
        'user_id' => 2,
        'platform_id' => 1,
        'platform_user_id' => 3,
        'auth_token' => sha1('fugafugafuga'),
        'expires' => '1988-07-22 00:00:00',
        'created' => '1988-07-22 00:00:00',
        'modified' => '1988-07-22 00:00:00',
      );

      UserEachPlatformAuthentication::add($testData);

      $params = null;

      try{
        $res = UserEachPlatformAuthentication::updateByPlatformIdAndUserId($params, 1, 1);
      }catch(\Exception $e){
        $this->assertEquals($e, new \SkyLogin\exception\UnexpectedParameterException);
      }

    }

  }


  protected function tearDown(){
    $table = UserEachPlatformAuthentication::table();
    UserEachPlatformAuthentication::connection()->query('TRUNCATE ' . $table->table);
  }


} 