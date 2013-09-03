<?php

namespace lib\model\dao;

use lib\exception\UnexpectedParameterException;
use lib\util\Validator;

class Role extends \lib\model\dao\BaseDao { 

  public static function getById($id){
    
    if(empty($id)){
      throw new UnexpectedParameterException;
    }
    return self::first($id);
    
  }
}
