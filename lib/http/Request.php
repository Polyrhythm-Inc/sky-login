<?php

namespace SkyLogin\lib\http;

class Request {

  private $map = array();

  private $method = 'get';

  private $methodMap = array('get', 'post', 'put', 'delete', 'patch', 'create', 'options');

  public function __construct(){
    $this->method = strtolower($_SERVER['REQUEST_METHOD']);
    $this->map = $_REQUEST;
  }

  public function __call($name, $args){


    if(substr($name, 0, 2) == 'is'){
      foreach ($this->methodMap as $key => $val) {
        if($name == 'is' . ucfirst($val) && $this->method == $val){
          return true;
        }
      }
      return false;
    }

    if(in_array($name, $this->methodMap)){
      if(isset($this->map[$args[0]]) && $name == $this->method){
        return $this->map[$args[0]];
      }
      return null;
    }


    throw new \Exception('Call to undefined method:' . $name);

  }
}