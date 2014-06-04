<?php

namespace SkyLogin\test\model\dao;

require_once dirname(__FILE__) . '/../../boot.php';

use SkyLogin\model\User;
use SkyLogin\exception\UnexpectedParameterException;
use SkyLogin\util\Utility;

class UserTest extends \PHPUnit_Framework_TestCase {

  protected function setUp(){
    $table = User::table();
    User::connection()->query('TRUNCATE ' . $table->table);
    $json = (array)\SkyLogin\util\Parser::json(SKYLOGIN_FIXTURES_PATH . '/User.json');
    User::create($json);
  }

  public function testGetByNameAndEmailAndPasswd(){
    
    /*正常系（該当レコード有り）*/
    {
      $name = "test_user";
      $email = 'test@sample.com';
      $password = 'd0be2dc421be4fcd0172e5afceea3970e2f3d940';

      $expected = array(
        "id" => 1,
        "user_id_relation_sequence_id" => 1,
        "name" => "test_user",
        "display_name" => '日本語入力OK',
        "email" => "test@sample.com",
        "password" => "d0be2dc421be4fcd0172e5afceea3970e2f3d940",
        "image_url" => null,
        "created" => null,
        "modified" => null
      );

      $results = User::getByNameAndEmailAndPasswd($name, $email, $password);
      
      $this->assertEquals($results->to_array(), $expected);
    }

    /*正常系(該当レコード無し)*/
    {
      $name = "testman";
      $email = 'test@sample.com';
      $password = 'p';
      $expected = null;

      $results = User::getByNameAndEmailAndPasswd($name, $email, $password);

      $this->assertEquals($results, $expected);
    }

    /*異常系（引数が不正）*/
    {
      try{

        $name = null;
        $email = null;
        $password = null;
        $results = User::getByNameAndEmailAndPasswd($name, $email, $password);

      }catch(UnexpectedParameterException $e){

        $this->assertEquals($e, new UnexpectedParameterException);

      }
    }

  }


  public function testGetByEmailAndPasswd(){
    
    /*正常系（該当レコード有り）*/
    {
      $email = 'test@sample.com';
      $password = 'd0be2dc421be4fcd0172e5afceea3970e2f3d940';

      $expected = array(
        "id" => 1,
        "user_id_relation_sequence_id" => 1,
        "name" => "test_user",
        "display_name" => '日本語入力OK',
        "email" => "test@sample.com",
        "password" => "d0be2dc421be4fcd0172e5afceea3970e2f3d940",
        "image_url" => null,
        "created" => null,
        "modified" => null
      );

      $results = User::getByEmailAndPasswd($email, $password);    
      
      $this->assertEquals($results->to_array(), $expected);
    }

    /*正常系(該当レコード無し)*/
    {
      $email = 'test@sample.com';
      $password = 'p';
      $expected = null;

      $results = User::getByEmailAndPasswd($email, $password);    

      $this->assertEquals($results, $expected);
    }

    /*異常系（引数が不正）*/
    {
      try{

        $email = null;
        $password = null;
        $results = User::getByEmailAndPasswd($email, $password);

      }catch(UnexpectedParameterException $e){

        $this->assertEquals($e, new UnexpectedParameterException);

      }
    }

  }


  public function testGetByNameAndPasswd(){
    
    /*正常系（該当レコード有り）*/
    {
      $name = 'test_user';
      $password = 'd0be2dc421be4fcd0172e5afceea3970e2f3d940';

      $expected = array(
        "id" => 1,
        "user_id_relation_sequence_id" => 1,
        "name" => "test_user",
        "display_name" => '日本語入力OK',
        "email" => "test@sample.com",
        "password" => "d0be2dc421be4fcd0172e5afceea3970e2f3d940",
        "image_url" => null,
        "created" => null,
        "modified" => null
      );

      $results = User::getByNameAndPasswd($name, $password);    
      
      $this->assertEquals($results->to_array(), $expected);
    }

    /*正常系(該当レコード無し)*/
    {
      $name = 'testman';
      $password = 'p';
      $expected = null;

      $results = User::getByNameAndPasswd($name, $password);    

      $this->assertEquals($results, $expected);
    }

    /*異常系（引数が不正）*/
    {
      try{

        $name = null;
        $password = null;
        $results = User::getByNameAndPasswd($name, $password);

      }catch(UnexpectedParameterException $e){

        $this->assertEquals($e, new UnexpectedParameterException);

      }
    }

  }



  public function testAdd(){
    
    //正常系
    {
      $testData = array(
        'name' => 'test_user_1',
        'user_id_relation_sequence_id' => 2,
        'email' => 'test2@sample.com',
        'password' => 'mypassword',
      );

      $res = User::add($testData);
      $this->assertNotNull(User::find($res->id));
    }


    //異常系(引数がnull)
    {
      $testData = null;

      try {

        $res = User::add($testData);

      }catch(UnexpectedParameterException $e){

        $this->assertEquals($e, new UnexpectedParameterException);

      }
     
    }

  }


  protected function tearDown(){
    $table = User::table();
    User::connection()->query('TRUNCATE ' . $table->table);
  }

}