<?php

namespace lib\util;

class Parser {

  public static function json($path){

    $json = json_decode(file_get_contents($path));

    if(is_null($json)){
      throw new \Exception('json parse error');
    }
    
    return $json;
  }

}