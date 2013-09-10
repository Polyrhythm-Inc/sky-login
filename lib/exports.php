<?php

namespace SkyLogin {

  class Request   extends  \SkyLogin\lib\http\Request {}
  class Platform  extends  \SkyLogin\lib\platform\Platform {}
  class Datastore extends  \SkyLogin\lib\configure\Datastore {}
  class Configure extends  \SkyLogin\lib\configure\Configure {}

}

namespace SkyLogin\model {

  class UserDevice extends \SkyLogin\lib\model\dao\UserDevice {}
  class User extends \SkyLogin\lib\model\dao\User {}
  class UserIdRelation extends \SkyLogin\lib\model\dao\UserIdRelation {}
  class UserEachPlatformAuthentication extends \SkyLogin\lib\model\dao\UserEachPlatformAuthentication {}
  class UserRole extends \SkyLogin\lib\model\dao\UserRole {}
  class Role extends \SkyLogin\lib\model\dao\Role {}

}