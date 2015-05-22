<?php

$environment = 'development';

switch (dirname(__FILE__)) {
    case '/Users/paveldanilov/Sites/sites.dev/elkey-landing':
    case 'd:\OpenServer\domains\sites.dev\elkey-landing':
    case 'D:\OpenServer\domains\sites.dev\elkey-landing':
        $protected = '/protected';
        break;
    default:
        $environment = 'production';
        $protected = '/../app/protected';
        break;
}

if ($environment == 'development') {
    $yii = dirname(__FILE__) . '/_framework/1.1.16/yii.php';
} else {
    $yii = dirname(__FILE__) . '/../../frameworks/Yii/1.1.16/yiilite.php';
}



if (($environment == 'development') || ($environment == 'test')) {
//    define('YII_DEBUG', false);
//    error_reporting(0);
    error_reporting(E_ALL);
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
} else {
    // error_reporting(E_ALL);
    // defined('YII_DEBUG') or define('YII_DEBUG', true);
    // defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
    define('YII_DEBUG', false);
    error_reporting(0);
}
?>