<?php

include dirname(__FILE__) . '/base_setting.php';

\SkyLogin\Platform::logout();

header('Location: /sky-login/sample/index.php');