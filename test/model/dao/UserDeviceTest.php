<?php

namespace SkyLogin\test\model\dao;

require_once dirname(__FILE__) . '/../../boot.php';

use SkyLogin\lib\model\dao\UserDevice;
use SkyLogin\lib\exception\UnexpectedParameterException;
use SkyLogin\lib\util\Utility;

class UserDeviceTest extends \PHPUnit_Framework_TestCase {

  protected function setUp(){
    $table = UserDevice::table();
    UserDevice::connection()->query('TRUNCATE ' . $table->table);
    $json = (array)\SkyLogin\lib\util\Parser::json(SKYLOGIN_FIXTURES_PATH . '/UserDevice.json');
    UserDevice::create($json);    
  }

  public function testAdd(){
    
    //正常系
    {

      $testData = array(
        'user_id' => 2,
        'device_id' => '25ab890e76d7801cda56abf9',
        'device_token' => '25ab890e76d7801cda56abf9',
        'os_type_id' => 2
      );

      $res = UserDevice::add($testData);
      $this->assertEquals($res, array('id' => 2));
    }


    //異常系(引数がnull)
    {
      $testData = null;

      try {
        $res = UserDevice::add($testData);
      }catch(UnexpectedParameterException $e){
        $this->assertEquals($e, new UnexpectedParameterException);
      }
     
    }

    //異常系(hashidに不適切な文字が含まれている)
    {

      $testData = array(
        'user_id' => 3,
        'device_id' => "' OR 1=1--",
        'device_token' => '25ab890e76d7801cda56abf2',
        'os_type_id' => 2
      );


      try {
        $res = UserDevice::add($testData);
      }catch(\ActiveRecord\DatabaseException $e){
        $this->assertEquals(get_class($e), "ActiveRecord\DatabaseException");
      }
    }
  }


  public function testGetByHashId(){
    //正常系
    {
      $hashId = Utility::createHashId('user_name1');
      $res = UserDevice::getByOsTypeIdAndDeviceId(1, '25ab890e76d7801cda56abf8');
      $this->assertNotNull(UserDevice::find($res['id']));
    }

    //異常系(引数がnull)
    {
      $hashId = null;

      try {
        $res = UserDevice::getByOsTypeIdAndDeviceId(null, null);
      }catch(UnexpectedParameterException $e){
        $this->assertEquals($e, new UnexpectedParameterException);
      }
     
    }

    //異常系(hashidに不適切な文字が含まれている)
    {
      $userId = 1;
      $deviceId = "' OR 1=1--";

      try {
        $res = UserDevice::getByOsTypeIdAndDeviceId($userId, $deviceId);
      }catch(\ActiveRecord\DatabaseException $e){
        $this->assertEquals(get_class($e), "ActiveRecord\DatabaseException");
      }
    }

  }



  public function testGetByUserId(){
    //正常系
    {

      $expected = array(
        'id' => 1,
        'user_id' => 1,
        "device_id"=> "25ab890e76d7801cda56abf8",
        "device_id_dec"=> 8563454077878840312,
        "device_token"=> "25ab890e76d7801cda56abf8",
        "os_type_id"=> 1,
        "last_login_datetime" => null,
        "created"=> "1988-07-22T00:00:00+0900",
        "modified"=> "1988-07-22T00:00:00+0900"
      );

      $res = UserDevice::getByUserId(1);
      $this->assertEquals($res->to_array(), $expected);
    }

    //異常系(引数がnull)
    {

      try {
        $res = UserDevice::getByUserId(null);
      }catch(UnexpectedParameterException $e){
        $this->assertEquals($e, new UnexpectedParameterException);
      }
     
    }

  }


  protected function tearDown(){
    $table = UserDevice::table();
    UserDevice::connection()->query('TRUNCATE ' . $table->table); 
  }

}