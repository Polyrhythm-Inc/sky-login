<?php

namespace SkyLogin\test\model\dao;

require_once dirname(__FILE__) . '/../../boot.php';

use SkyLogin\exception\UnexpectedParameterException;
use SkyLogin\util\Utility;
use SkyLogin\model\Role;

class RoleTest extends \PHPUnit_Framework_TestCase {


  protected function setUp(){
    Role::setJsonPath();
  }

  public function testGetById(){

    //正常系
    {

      $this->assertEquals(Role::getById(1),
        array(
          "id"=> 1,
          "name"=> "admin",
          "name_ja" => "管理者",
          "group" => 1
      ));
    }


    //異常系（引数がnull）
    {
      try{
        $res = Role::getById(null);
      }catch(\Exception $e){
        $this->assertEquals($e, new \SkyLogin\exception\UnexpectedParameterException);
      }
    }
  }


  protected function tearDown(){}


} 