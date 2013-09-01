<?php

namespace test\model\dao;

require_once dirname(__FILE__) . '/../../boot.php';
require_once LIB_PATH . '/model/dao/User.php';

use lib\model\dao\UserIdRelation;
use lib\exception\UnexpectedParameterException;
use lib\util\Utility;

class UserIdRelationTest extends \PHPUnit_Framework_TestCase {

  private $tableName = 'user_id_relations';

  protected function setUp(){
    UserIdRelation::connection()->query('TRUNCATE ' . $this->tableName);
  }

  public function testAdd(){
    
    //正常系
    {
      $res = UserIdRelation::add(Utility::createHashId('user_name1'));
      $this->assertNotNull(UserIdRelation::find($res->id));
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

  }


  protected function tearDown(){
    UserIdRelation::connection()->query('TRUNCATE ' . $this->tableName);
  }

}