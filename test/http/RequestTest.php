<?php

namespace SkyLogin\test\http;

require_once dirname(__FILE__) . '/../boot.php';
require_once SKYLOGIN_LIB_PATH . '/http/Request.php';

use SkyLogin\http\Request;

class RequestTest extends \PHPUnit_Framework_TestCase {


  protected function setUp(){
    $_REQUEST['dog'] = 'inu';
    $_REQUEST['cat'] = 'neko';
  }

  public function testGetFunc(){

    $_SERVER['REQUEST_METHOD'] = 'GET';

    $req = new Request();

    $this->assertTrue($req->isGet());
    $this->assertFalse($req->isPost());
    $this->assertEquals($req->get('dog'), 'inu');
    $this->assertNull($req->get('shark'));

  }


  public function testPostFunc(){

    $_SERVER['REQUEST_METHOD'] = 'POST';

    $req = new Request();

    $this->assertTrue($req->isPost());
    $this->assertFalse($req->isGet());
    $this->assertEquals($req->post('cat'), 'neko');
    $this->assertNull($req->post('shark'));

  }


}