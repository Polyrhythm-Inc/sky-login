<?php

namespace SkyLogin\platform;

class Status {

  public function __construct($stat){
    foreach ($stat as $key => $value) {
      $this->$key = $value;
    }
  }

}
