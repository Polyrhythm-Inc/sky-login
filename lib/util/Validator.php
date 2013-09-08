<?php

namespace SkyLogin\lib\util;

use SkyLogin\lib\exception\UnexpectedParameterException;

class Validator {

  public static function required($target = array(), $requiredParams = array()){

    if(empty($target)){ throw new UnexpectedParameterException; }

    $keys = array();
    foreach ($target as $key => $value) {
      $keys[] = $key;
    }

    foreach ($requiredParams as $key => $value) {
      if(!in_array($value, $keys)){
        throw new UnexpectedParameterException;
      }
    }

  }

}