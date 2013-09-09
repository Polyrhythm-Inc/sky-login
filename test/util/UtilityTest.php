<?php

namespace SkyLogin\test\util;

require_once dirname(__FILE__) . '/../boot.php';

use SkyLogin\lib\exception\UnexpectedParameterException;
use SkyLogin\lib\util\Utility;

class UtilityTest extends \PHPUnit_Framework_TestCase {

  public function testIsValidEmailFormat(){
    
    /*正常系（フォーマットがメールアドレス）*/
    {

      $testData = 'sample@test.com';
      $res = Utility::isValidEmailFormat($testData);
      $this->assertTrue($res);
    }

    /*正常系（フォーマットがメールアドレスではない）*/
    {
      $testData = 'sample_test.com';
      $res = Utility::isValidEmailFormat($testData);
      $this->assertFalse($res);
    }

  }

}