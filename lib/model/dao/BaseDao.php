<?php

namespace SkyLogin\model;

\ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';

abstract class BaseDao extends \ActiveRecord\Model{

}