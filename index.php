<?php

$config_file = 'main.php';

require_once(dirname( __FILE__ ) . '/environment.php');

require_once($yii);

$config_server = dirname( __FILE__ ) . $protected . '/config/environment/' . $environment . '.php';

$app_class_path = dirname(__FILE__) . $protected . '/modules/core/components/base/BaseWebApplication.php';
require_once($app_class_path);

Yii::createApplication('BaseWebApplication', $config_server)->run();

?>
