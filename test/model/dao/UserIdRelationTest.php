<?php

namespace SkyLogin\test\model\dao;

require_once dirname(__FILE__) . '/../../boot.php';

use SkyLogin\model\UserIdRelation;
use SkyLogin\exception\UnexpectedParameterException;
use SkyLogin\util\Utility;

class UserIdRelationTest extends \PHPUnit_Framework_TestCase {

  private $tableName = 'user_id_relations';

  protected function setUp(){
    $table = UserIdRelation::table();
    UserIdRelation::connection()->query('TRUNCATE ' . $table->table);
  }

  public function testAdd(){
    
    //正常系
    {
      $res = UserIdRelation::add(Utility::createHashId('user_name1'));
      $this->assertEquals($res, array('id' => '1'));
    }


    //異常系(引数がnull)
    {
      $testData = null;

      try {
        $res = UserIdRelation::add($testData);
      }catch(UnexpectedParameterException $e){
        $this->assertEquals($e, new UnexpectedParameterException);
      }
     
    }

    //異常系(hashidに不適切な文字が含まれている)
    {
      $testData = "' OR 1=1--";

      try {
        $res = UserIdRelation::add($testData);
      }catch(\ActiveRecord\DatabaseException $e){
        $this->assertEquals(get_class($e), "ActiveRecord\DatabaseException");
      }
    }
  }

  public function testGetByHashId(){
    //正常系
    {
      $hashId = Utility::createHashId('user_name1');
      UserIdRelation::add($hashId);
      $res = UserIdRelation::getByHashId($hashId);
      $this->assertNotNull(UserIdRelation::find($res['id']));
    }

    //異常系(引数がnull)
    {
      $hashId = null;

      try {
        $res = UserIdRelation::getByHashId($hashId);
      }catch(UnexpectedParameterException $e){
        $this->assertEquals($e, new UnexpectedParameterException);
      }
     
    }

    //異常系(hashidに不適切な文字が含まれている)
    {
      $hashId = "' OR 1=1--";

      try {
        $res = UserIdRelation::getByHashId($hashId);
      }catch(\ActiveRecord\DatabaseException $e){
        $this->assertEquals(get_class($e), "ActiveRecord\DatabaseException");
      }
    }

  }


  protected function tearDown(){
    $table = UserIdRelation::table();
    UserIdRelation::connection()->query('TRUNCATE ' . $table->table);
  }

}