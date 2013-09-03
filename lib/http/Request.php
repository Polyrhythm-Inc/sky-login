<?php

namespace lib\http;

class Request {

  private $map = array();

  private $method = 'get';

  private $methodMap = array('get', 'post', 'put', 'delete', 'patch', 'create', 'options');

  public function __construct(){
    $this->method = strtolower($_SERVER['REQUEST_METHOD']);
    $this->map = $_REQUEST;
  }

  public function __call($name, $args){

    if(in_array($name, $this->methodMap) && $name == $this->method){
      if(isset($this->map[$args[0]])){
        return $this->map[$args[0]];
      }
      return null;
    }

    return null;

  }
}