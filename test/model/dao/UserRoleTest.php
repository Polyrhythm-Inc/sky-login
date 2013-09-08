<?php

namespace SkyLogin\test\model\dao;

require_once dirname(__FILE__) . '/../../boot.php';
require_once SKYLOGIN_LIB_PATH . '/model/dao/UserRole.php';

use SkyLogin\lib\exception\UnexpectedParameterException;
use SkyLogin\lib\util\Utility;
use SkyLogin\lib\model\dao\UserRole;

class UserRoleTest extends \PHPUnit_Framework_TestCase {


  protected function setUp(){
    $table = UserRole::table();
    UserRole::connection()->query('TRUNCATE ' . $table->table);
  }


  public function testGetByUserIdAndRoleId(){

    //正常系
    {
      $json = (array)\SkyLogin\lib\util\Parser::json(SKYLOGIN_FIXTURES_PATH . '/UserRole.json');
      UserRole::create($json);

      $expected = array(
        "id" => 1,
        "user_id" => 1,
        "role_id" => 1,
        "created" => "1988-07-22T00:00:00+0900",
        "modified" => "1988-07-22T00:00:00+0900"
      );

      $res = UserRole::getByUserIdAndRoleId(1, 1);
      $this->assertEquals($res->to_array(), $expected);
    }

    //異常系
    {
      try{
        $res = UserRole::getByUserIdAndRoleId(null, null);
      }catch(\Exception $e){
        $this->assertEquals($e, new UnexpectedParameterException);
      }
    }

  }


  public function testAdd(){

    //正常系
    {
      $testData = array(
        "user_id" => 2,
        "role_id" => 2
      );

      $res = UserRole::add($testData);
      $this->assertNotNull(UserRole::find($res->id));
    }


    //異常系(引数がnull)
    {
      $testData = null;

      try {

        $res = UserRole::add($testData);

      }catch(UnexpectedParameterException $e){

        $this->assertEquals($e, new UnexpectedParameterException);

      }
     
    }

  }


  public function testDelteByUserIdAndRoleId(){

    //正常系
    {

      $json = (array)\SkyLogin\lib\util\Parser::json(SKYLOGIN_FIXTURES_PATH . '/UserRole.json');
      UserRole::create($json);

      $res = UserRole::delteByUserIdAndRoleId(1, 1);
      $this->assertTrue($res);
    }


    //異常系(引数がnull)
    {

      try {

        $res = UserRole::delteByUserIdAndRoleId(null, null);

      }catch(UnexpectedParameterException $e){

        $this->assertEquals($e, new UnexpectedParameterException);

      }
     
    }

  }


  protected function tearDown(){
    $table = UserRole::table();
    UserRole::connection()->query('TRUNCATE ' . $table->table);
  }


} 