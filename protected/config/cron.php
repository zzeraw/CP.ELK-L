<?php

require_once(dirname(__FILE__) . '/params.php');

return array(
	'basePath'       => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name'           => 'CHRONOMETRY',
    'sourceLanguage' => 'ru',
    'language'       => 'ru',
    'timeZone'       => 'Europe/Moscow',

    'preload' => array('log'),

    'import' => array(
        'application.modules.core.components.base.*',
        'application.modules.core.components.actions.*',

        'application.commands.*',
        'application.vendors.*',
    ),

	'behaviors' => array(

	),

	// application components
	'components' => array(

	),

    'modules' => array(
        'chronometry',
        'core',
        'user',
    ),

	'params' => $params,
);