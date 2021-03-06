<?php

return CMap::mergeArray(
    require(dirname(__FILE__) . '/../main.php'),
    array(
        'components'=>array(
            'db' => array(
                'connectionString' => 'mysql:host=localhost;dbname=####',
                'emulatePrepare' => true,
                'username' => '####',
                'password' => '####',
                'charset' => 'utf8',
                'tablePrefix' => '',
            ),
            'log' => array(
                'class'=>'CLogRouter',
                'routes'=>array(
                    array(
                        'class' => 'CEmailLogRoute',
//                        'categories' => 'errors',
                        'levels' => CLogger::LEVEL_ERROR,
                        'emails' => array('pv.danilov.dev@yandex.ru'),
                        'sentFrom' => 'log@elkey.biz',
                        'subject' => 'Критическая ошибка на elkey.biz',
                    ),
                    array(
                        'class' => 'CEmailLogRoute',
//                        'categories' => 'warnings',
                        'levels' => CLogger::LEVEL_WARNING,
                        'emails' => array('pv.danilov.dev@yandex.ru'),
                        'sentFrom' => 'log@elkey.biz',
                        'subject' => 'Ошибка на elkey.biz',
                    ),
                ),
            ),
            'amocrm' => array(
                'class' => 'application.extensions.EAmoCRM.EAmoCRM',
                'subdomain' => '', // Персональный поддомен на сайте amoCRM
                'login' => '', // Логин на сайте amoCRM
                'password' => '', // Пароль на сайте amoCRM
                // 'hash' => '00000000000000000000000000000000', // Вместо пароля можно использовать API ключ
            ),

        ),
        'modules' => array(
            // uncomment the following to enable the Gii tool
            'gii' => array(),
        ),
    )
);

?>