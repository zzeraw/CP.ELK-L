<?php

require_once(dirname(__FILE__) . '/params.php');

return array(
	'basePath'       => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name'           => 'CHRONOMETRY',
    'sourceLanguage' => 'ru',
    'language'       => 'ru',
    'timeZone'       => 'Europe/Moscow',

    'defaultController' => 'pages/default/view/',

    // preloading 'log' component
    'preload' => array('log'),

    'import' => array(

        'application.modules.core.behaviors.*',
        'application.modules.core.components.base.*',
        'application.modules.core.components.controllers.*',
        'application.modules.core.components.actions.*',

        'application.vendors.*',
    ),

	// используемые приложением поведения
	'behaviors' => array(

	),

	// application components
	'components' => array(
		'errorHandler' => array(
			'errorAction' => 'core/core/error',
		),
        'log' => array(
            'class'=>'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),

        // пользователь
        'user' => array(
            'class' => 'application.modules.user.components.WebUser',
            // enable cookie-based authentication
            'allowAutoLogin' => true,
            'loginUrl' => array('/user/login'),
        ),

        'clientScript' => array(
            'coreScriptPosition' => CClientScript::POS_BEGIN,
            'packages' => array(
                'jquery' => array(
                    'baseUrl' => 'js/',
                    'js' => array(
                        YII_DEBUG ? 'jquery-1.11.1.js' : 'jquery-1.11.1.min.js'
                    ),
                ),
                // 'bootstrap3' => array(
                //     'baseUrl' => '',
                //     'js' => array(
                //         YII_DEBUG ? 'js/bootstrap.js' : 'js/bootstrap.min.js'
                //     ),
                //     'css' => array(
                //         'css/bootstrap.min.css',
                //         'css/bootstrap-theme.min.css',
                //     ),
                //     'depends' =>array('jquery'),
                // ),
                // 'modernizr' => array(
                //     'baseUrl' => '',
                //     'js' => array(
                //         'js/modernizr-2.6.2-respond-1.1.0.min.js'
                //     ),
                // ),
                // 'my-js' => array(
                //     'baseUrl' => 'js/',
                //     'js' => array(
                //         YII_DEBUG ? 'main.js' : 'main.min.js'
                //     ),
                //     'depends' =>array('jquery'),
                // ),
                // 'my-css' => array(
                //     'baseUrl' => 'css/',
                //     'css' => array('styles.css?css=1'),
                // ),
            ),
        ),

        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'urlSuffix' => '/',
            'rules' => array(
                // array('sitemap/default/xml', 'pattern'=>'sitemap.xml', 'urlSuffix'=>''),
                // array('sitemap/default/index', 'pattern'=>'sitemap', 'urlSuffix'=>'/'),

//                    'forms/ajax/<action:\d+>/*' => 'forms/ajax/<action>',
                '<module:(forms)>/<controller:(ajax)>/<action:\w+>' => '<module>/<controller>/<action>',

                // 'catalog' => 'catalog/default/index',
                // 'catalog/group/<id:\d+>' => 'catalog/default/group',
                // 'catalog/item/<id:\d+>/replace/<replace>' => 'catalog/default/view/',
                // 'catalog/item/<id:\d+>' => 'catalog/default/view/',

                '<alias:[\w\-]+>/*' => array('pages/default/view/', 'alias'=>'<alias>'),
            ),
        ),
	),

    'modules' => array(
        'core',
        'pages',
        'blocks',
        'forms',
        'user' => array(
            # encrypting method (php hash function)
            'hash' => 'sha1',

            # send activation email
            'sendActivationMail' => true,

            # allow access for non-activated users
            'loginNotActiv' => false,

            # activate user on registration (only sendActivationMail = false)
            'activeAfterRegister' => false,

            # automatically login from registration
            'autoLogin' => true,

            # registration path
            'registrationUrl' => array('/user/registration'),

            # recovery password path
            'recoveryUrl' => array('/user/recovery'),

            # login form path
            'loginUrl' => array('/user/login'),

            # page after login
            'returnUrl' => array('/user/profile'),

            # page after logout
            'returnLogoutUrl' => array('/user/login'),
        ),
    ),

	'params' => $params,


);