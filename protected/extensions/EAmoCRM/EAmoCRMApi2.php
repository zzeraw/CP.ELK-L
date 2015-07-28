<?php
/**
 * EAmoCRM class file.
 *
 * @package YiiAmoCRM
 * @author dZ <mail@dotzero.ru>
 * @link http://www.dotzero.ru
 * @link https://github.com/dotzero/YiiAmoCRM
 * @link https://www.amocrm.ru/add-ons/api.php
 * @license MIT
 * @version 1.0 (25-nov-2013)
 */

/**
 * EAmoCRM это расширение для Yii PHP framework которое выступает в качестве простого прокси для обращения
 * к API сайта amoCRM. Структуры и данных для передачи нелогичны, за дополнительными разъяснениями
 * можно обратится к официальный документации amoCRM (https://www.amocrm.ru/add-ons/api.php)
 *
 * Требования:
 * Yii Framework 1.1.0 или новее
 *
 * Установка:
 * - Скопировать папку EAmoCRM в 'protected/extensions'
 * - Добавить в секцию 'components' конфигурационного файла:
 *
 *  'amocrm' => array(
 *      'class' => 'application.extensions.EAmoCRM.EAmoCRM',
 *      'subdomain' => 'example', // Персональный поддомен на сайте amoCRM
 *      'login' => 'login@mail.com', // Логин на сайте amoCRM
 *      'password' => '123456', // Пароль на сайте amoCRM
 *      'hash' => '00000000000000000000000000000000', // Вместо пароля можно использовать API ключ
 *  ),
 *
 * Пример использования:
 *
 * // Проверка авторизации на сайте amoCRM
 * $result = Yii::app()->amocrm->ping();
 *
 * // Получение 1 страницы со списком контактов, >на странице 20 записей
 * $result = Yii::app()->amocrm->listContacts(1, 20);
 */
class EAmoCRMApi2 extends CApplicationComponent
{
    /**
     * @var null|string Персональный поддомен на сайте amoCRM
     */
    public $subdomain = null;
    /**
     * @var null|string Логин на сайте amoCRM
     */
    public $login = null;
    /**
     * @var null|string Пароль на сайте amoCRM
     */
    public $password = null;
    /**
     * @var null|string API ключ для доступа
     */
    public $hash = null;
    /**
     * @var mixed Сообщение о последней ошибке
     */
    private $lastError = null;
    /**
     * @var mixed Код последней ошибки
     */
    private $lastErrorNo = null;

    /**
     * Типы задач
     */
    const TASK_CALL = 'CALL';
    const TASK_LETTER = 'LETTER';
    const TASK_MEETING = 'MEETING';

    /**
     * Initializes the application component.
     */
    public function init()
    {
        parent::init();
    }

    /**
     * Проверка авторизации на сайте amoCRM
     *
     * @return bool
     * @throws CException
     */
    public function ping()
    {
        $result = $this->call('/private/api/auth.php');

        return (isset($result['auth']) AND $result['auth'] === 'true');
    }

    /**
     * Добавление контакта в amoCRM
     *
     * @param array $data Структура данных
     * @example Пример структуры данных
     *  array(
     *      'person_name' => 'Фамилия Имя',
     *      'person_position' => 'Должность',
     *      'person_company_name' => 'Компания',
     *      'person_company_id' => '0',
     *      'contact_data' => array(
     *          'phone_numbers' => array(
     *              array('number' => '+7 495 123-45-67'),
     *              array('location' => 'Work'),
     *              array('number' => '+7 499 891-01-11'),
     *              array('location' => 'Mobile')
     *          ),
     *          'email_addresses' => array(
     *              array('address' => 'mail@mail.ru'),
     *              array('location' => 'Work')
     *          ),
     *          'web_addresses' => array(
     *              array('url' => 'http://example.com')
     *          ),
     *          'addresses' => array(
     *              array('street' => 'Moscow, Russia')
     *          ),
     *          'instant_messengers' => array(
     *              array('address' => 'imaddr'),
     *              array('protocol' => 'Skype')
     *          )
     *      ),
     *      'main_user_id' => '1',
     *      'tags' => 'тег, тег2, тег3'
     *  )
     * @return mixed
     * @throws CException
     */
    public function addContact($data)
    {
        $params = array(
            'ACTION' => 'ADD_PERSON',
            'contact' => serialize($data)
        );

        return $this->call('/private/api/contact_add.php', $params);
    }

    /**
     * Добавление сделки в amoCRM
     *
     * @param array $data Структура данных
     * @example Пример структуры данных
     *  array(
     *      'name' => 'Название сделки',
     *      'status_id' => 'ID статуса сделки',
     *      'price' => 'Цена (число)',
     *      'main_user_id' => 'ID ответственного пользователя',
     *      'tags' => 'тег, тег2, тег3',
     *      'linked_contact' => 'ID связанного контакта'
     * )
     * @return mixed
     * @throws CException
     */
    public function addDeal($data)
    {
        $params = array(
            'ACTION' => 'ADD',
            'deal' => serialize($data)
        );

        return $this->call('/private/api/deal_add.php', $params);
    }

    /**
     * Добавление примечания к контакту в amoCRM
     *
     * @param integer $id ID контакта
     * @param $message Текст примечания
     * @return mixed
     * @throws CException
     */
    public function addContactNote($id, $message)
    {
        $params = array(
            'ID' => $id,
            'ACTION' => 'ADD_NOTE',
            'BODY' => $message,
            'ELEMENT_TYPE' => 1
        );

        return $this->call('/private/api/note_add.php', $params);
    }

    /**
     * Добавление примечания к сделке в amoCRM
     *
     * @param integer $id ID контакта
     * @param $message Текст примечания
     * @return mixed
     * @throws CException
     */
    public function addDealNote($id, $message)
    {
        $params = array(
            'ID' => $id,
            'ACTION' => 'ADD_NOTE',
            'BODY' => $message,
            'ELEMENT_TYPE' => 2
        );

        return $this->call('/private/api/note_add.php', $params);
    }

    public function addTask($element_id, $element_type, $task_type, $text, $responsible_user_id, $complete_till)
    {
        $tasks['request']['tasks']['add'] = array(
            array(
                'element_id' => $element_id,
                'element_type' => $element_type,
                'date_create' => time(),
                'last_modified' => time(),
                'task_type' => $task_type,
                'text' => $text,
                'responsible_user_id' => $responsible_user_id,
                'complete_till' => $complete_till,
            ),
        );

        return $this->callV2('/private/api/v2/json/tasks/set', $tasks);
    }

    public function addContactTask($contact_id, $task_type, $text, $responsible_user_id, $complete_till)
    {
        $tasks['request']['tasks']['add'] = array(
            #Привязываем к сделке
            array(
                'element_id' => $contact_id,
                'element_type' => 1,
                'date_create' => time(),
                'last_modified' => time(),
                'task_type' => $task_type,
                'text' => $text,
                'responsible_user_id' => $responsible_user_id,
                'complete_till' => $complete_till,
            ),
        );

        return $this->callV2('/private/api/v2/json/tasks/set', $tasks);
    }

    public function addDealTask($deal_id, $task_type, $text, $responsible_user_id, $complete_till)
    {
        $tasks['request']['tasks']['add'] = array(
            #Привязываем к сделке
            array(
                'element_id' => $deal_id,
                'element_type' => 2,
                'date_create' => time(),
                'last_modified' => time(),
                'task_type' => $task_type,
                'text' => $text,
                'responsible_user_id' => $responsible_user_id,
                'complete_till' => $complete_till,
            ),
        );

        return $this->call('/private/api/v2/json/tasks/set', $tasks);
    }

/**
     * Обращение к API V2 amoCRM
     *
     * @param string $url
     * @param array $params
     * @param bool $raw
     * @return mixed
     * @throws CException
     */
    public function call($url, $params = array())
    {
        $this->lastError = null;

        $params['USER_LOGIN'] = $this->login;

        if ($this->hash !== null) {
            $params['USER_HASH'] = $this->hash;
        } elseif ($this->password !== null) {
            $params['USER_PASSWORD'] = $this->password;
        } else {
            throw new CException('User Password or Hash are required to authorize.');
        }

        $link='https://'.$this->subdomain.'.amocrm.ru' . $url;

        $curl = curl_init(); #Сохраняем дескриптор сеанса cURL

        #Устанавливаем необходимые опции для сеанса cURL
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
        curl_setopt($curl,CURLOPT_URL,$link);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
        curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);


        $out = curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
        $code = curl_getinfo($curl,CURLINFO_HTTP_CODE); #Получим HTTP-код ответа сервера
        curl_close($curl); #Завершаем сеанс cURL

        switch ($code) {
            case '301':
                $this->lastError = 'Ошибка. Запрошенный документ был окончательно перенесен.';
                break;
            case '400':
                $this->lastError = 'Ошибка. Сервер обнаружил в запросе клиента синтаксическую ошибку.';
                break;
            case '401':
                $this->lastError = 'Ошибка. Запрос требует идентификации пользователя.';
                break;
            case '403':
                $this->lastError = 'Ошибка. Ограничение в доступе к указанному ресурсу.';
                break;
            case '404':
                $this->lastError = 'Ошибка. Страница не найдена.';
                break;
            case '500':
                $this->lastError = 'Внутрення ошибка сервера.';
                break;
            case '502':
                $this->lastError = 'Ошибка. Неудачное выполнение.';
                break;
            case '503':
                $this->lastError = 'Ошибка. Сервер временно недоступен.';
                break;
            default:
                $this->lastError = 'Ошибка авторизации. Пожалуйста, проверьте введённые данные.';
        }

        if ($code != 200) {
            $this->lastErrorNo = $code;
            throw new CException($this->lastError, $this->lastErrorNo);
        }

        $result = json_decode($out);

        return $result;
    }
}
