<?php

namespace test\model\dao;

require_once dirname(__FILE__) . '/../../boot.php';
require_once SKYLOGIN_LIB_PATH . '/model/dao/Role.php';

use lib\exception\UnexpectedParameterException;
use lib\util\Utility;
use lib\model\dao\Role;

class RoleTest extends \PHPUnit_Framework_TestCase {


  protected function setUp(){
    $table = Role::table();
    Role::connection()->query('TRUNCATE ' . $table->table);
  }

  public function testGetById(){

    //正常系
    {
      $json = (array)\lib\util\Parser::json(SKYLOGIN_FIXTURES_PATH . '/Role.json');
      $res = Role::create($json);
      $this->assertNotNull(Role::getById($res->id));
    }


    //異常系（引数がnull）
    {
      try{
        $res = Role::getById(null);
      }catch(\Exception $e){
        $this->assertEquals($e, new \lib\exception\UnexpectedParameterException);
      }
    }
  }


  protected function tearDown(){
    $table = Role::table();
    Role::connection()->query('TRUNCATE ' . $table->table);
  }


} 