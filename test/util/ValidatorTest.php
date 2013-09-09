<?php

namespace SkyLogin\test\util;

require_once dirname(__FILE__) . '/../boot.php';

use SkyLogin\lib\exception\UnexpectedParameterException;
use SkyLogin\lib\util\Validator;

class ValidatorTest extends \PHPUnit_Framework_TestCase {

  public function testRequired(){
    
    /*正常系（エラー無し）*/
    {

      $testData = array(
        'user_id' => 1,
        'user_name' => 'name' ,
        'age' => 25,
        'div' => 'development'
      );

      $results = Validator::required(
        array(
          'user_id',
          'user_name',
          'age',
          'div'
        )
      );
      
      $this->assertTrue($results);
    }


    /*異常系（引数が不正）*/
    {
      try{

        $testData = array();

        Validator::required($testData, array('hoge', 'fuga'));


      }catch(UnexpectedParameterException $e){

        $this->assertEquals($e, new UnexpectedParameterException);

      }
    }

  }


}