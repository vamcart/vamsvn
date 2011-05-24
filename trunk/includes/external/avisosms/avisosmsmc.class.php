<?php
/**
 * Класс для работы с сервисом AvisoSMS Мобильная коммерция
 *
 * Документация: http://avisosms.ru/m-commerce/api/
 *
 * @author
 * @copyright
 * @license
 */
class AvisosmsMCommerce {

    /**
     * @var  Ссылка до API
     */
    public $url         = 'https://api.avisosms.ru/mc/';

    /**
     * @var  Имя пользователя в системе AvisoSMS
     */
    public $username    = NULL;

    /**
     * @var  Ключ доступа. Указывается в настройках аккаунта (Настройки удалённого доступа)
     */
    public $access_key  = NULL;

    /**
     * @var  ID сервиса
     */
    public $service_id  = NULL;
    
    /**
     * @var  Время ожидания ответа от сервера в секундах
     */
    public $timeout     = 10;

    /**
     * @var  Кодировка приложения
     */
    public $out_charset = 'UTF-8';

    /**
     * @var  Расшифровка статусов заказов.
     */
    public $order_status    = array(
        'success' => 'Заказ успешно оплачен',
        'failure' => 'Заказ не был оплачен',
        'cancel'  => 'Заказ был отменён пользователем со стороны сотового оператора',
        'pending' => 'Заказ обрабатывается',
    );

    /**
     * @var  Расшифровка статусов.
     */
    private $_status    = array(
        '0' => 'Нет ошибок. Операция произведена успешно',
        '1' => 'Неожиданная ошибка. Этой ошибки быть не должно',
        '2' => 'Эта ошибка может возникнуть, если для данного номера не доступна услуга мобильной коммерции',
        '3' => 'Некоторые параметры переданы неверно или не переданы',
        '4' => 'Ошибка авторизации',

        '255' => 'Ошибка соединения с сервером',
    );

    private $_response = NULL;
    private $_error_message = NULL;

    /**
     * @var  Режим тестирования
     */
    public $test        = FALSE;
    public $debug_text  = '';

    /**
     * @var  Кодировка скрипта
     */
    const CHARSET = 'UTF-8';

    /**
     * Конструктор
     *
     *      // Создаем новый объект для работы с avisosms m_commerce
     *      $m_commerce = new avisosms_m_commerce($username, $access_key, $service_id);
     *      // Включаем тестовый режим
     *      $m_commerce->test = TRUE;
     *      $m_commerce->debug = TRUE;
     *
     * @param   string  Имя пользователя в системе AvisoSMS.
     * @param   string  Ключ доступа. Указывается в настройках платформы.
     * @param   string  ID сервиса. Указывается в личном кабинете.
     *
     * @return  boolean TRUE
     */
    function AvisosmsMCommerce($username, $access_key, $service_id)
    {
        $this->username     = $username;
        $this->access_key   = $access_key;
        $this->service_id   = $service_id;
        return TRUE;
    }

    /**
     * Создание заказа
     *
     *      if ($m_commerce->createOrder($description, $price, $success_message, $phone, ''))
     *      {
     *          // Заказ создан успешно (status = 0)
     *          $response = $m_commerce->response();
     *          var_dump($response);
     *      }
     *      else
     *      {
     *          // Ошибка создания заказа (status > 0)
     *          echo 'Ошибка: '.$m_commerce->error_message();
     *          var_dump($m_commerce->response());
     *      }
     *
     * @param   string  Описание заказа. Максимальная длина 100 символов, минимальная - 10.
     * @param   string  Сумма заказа. Дробные числа указываются через точку. Максимум до сотых долей.
     * @param   string  Сообщение, отправляемое пользователю, в случае успешного завершения оплаты.
     * @param   string  Телефон абонента.
     * @param   string  Необязательный параметр. ID платежа в системе магазина. До 100 знаков.
     *
     * @return  boolean Возвращает TRUE, если status = 0, иначе FALSE
     */
    function createOrder($description, $price, $success_message, $phone, $merchant_order_id = '')
    {
        $data = array(
            'username'          => $this->username,
            'access_key'        => $this->access_key,
            'description'       => $description,
            'price'             => (float)number_format($price, 2, '.', ''),
            'success_message'   => $success_message,
            'phone'             => $phone,
            'service_id'        => $this->service_id,
            'merchant_order_id' => $merchant_order_id,
        );
        return $this->send($data, 'create_order');
    }

    /**
     * Запрос статуса заказа
     *
     *      if ($m_commerce->getOrderStatus('4d2c8957f612fc6f3c0003e4'))
     *      {
     *          // Данные получены успешно (status = 0)
     *          $response = $m_commerce->response();
     *          var_dump($response);
     *      }
     *      else
     *      {
     *          // Ошибка получение данных (status > 0)
     *          echo 'Ошибка: '.$m_commerce->error_message();
     *          var_dump($m_commerce->response());
     *      }
     *
     * @param   string  ID заказа
     *
     * @return  boolean Возвращает TRUE, если status = 0, иначе FALSE
     */
    function getOrderStatus($order_id)
    {
        $data = array(
            'username'          => $this->username,
            'access_key'        => $this->access_key,
            'service_id'        => $this->service_id,
            'order_id'          => $order_id,
        );
        return $this->send($data, 'get_order_info');
    }
    
    /**
     * Уведомление о статусе
     *
     *      if ($m_commerce->updateOrderStatus())
     *      {
     *          // Данные получены, проверка access_key пройдена
     *          // Можно обрабатывать полученные данные
     *          $response = $m_commerce->response();
     *          var_dump($response);
     *      }
     *      else
     *      {
     *          // Переданные данные не верны.
     *          die('Ошибка: '.$m_commerce->error_message());
     *      }
     *
     * @param   array  Массив с переданными данными (если получаются самостоятельно)
     *
     * @return  boolean Возвращает TRUE, если status = 0, иначе FALSE
     */
    function updateOrderStatus($data = NULL)
    {
        $options = array(
                'access_key' => NULL,
                'order_id' => '',
                'order_status' => '',
                'merchant_order_id' => ''
            );
        
        if (is_null($data))
        {
            $data = file_get_contents("php://input");
            $data = json_decode($data);
        }
        
        $this->_response = array_merge($options, (array) $data);
        
        if (!($this->access_key === $this->_response['access_key']))
        {
            $this->_error_message = 'Не верный ключ доступа.';
            return FALSE;
        }
        
        return TRUE;
    }

    /**
     * Обращение к API
     *
     * @param   array       Массив с данными
     * @param   string      Название функции
     * @return  boolean Возвращает TRUE, если status = 0, иначе FALSE
     */
    function send($data, $postfix)
    {
        if ($this->test) $data['test'] = TRUE;
        if ($this->out_charset <> self::CHARSET) foreach($data as $k => $v) $data[$k] = iconv($this->out_charset, self::CHARSET, $v);
        
        $url = $this->url.$postfix.'/';
        $json_data = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_COOKIE, 0); 
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

        $result = curl_exec($ch);
        
        $this->debug_text = 'Передаем запрос '.$url.': <br><pre>'.$json_data.'</pre>';
        $this->debug_text .= 'Получаем ответ: <br><pre>'.$result.'</pre>';
        $this->_response = array('status' => 255);

        if (curl_errno($ch))
        {
            $this->_error_message = curl_error($ch);
        }
        else
        {
            $this->_response = array_merge($this->_response, (array)json_decode($result, TRUE));
            $this->_error_message = $this->_status[$this->_response['status']];
        }

        curl_close($ch);
        return !$this->_response['status'];
        
    }

    /**
     * Возвращает ответ от сервера
     *
     * @return  array   Ответ от сервера
     */
    public function response()
    {
        $data = $this->_response;
        if ($this->out_charset <> self::CHARSET) foreach($data as $k => $v) $data[$k] = iconv(self::CHARSET, $this->out_charset, $v);
        return $data;
    }

    /**
     * Возвращает текст ошибки
     *
     * @return  string   Текст ошибки
     */
    public function error_message()
    {
        return ($this->out_charset == self::CHARSET) ? $this->_error_message : iconv(self::CHARSET, $this->out_charset, $this->_error_message);
    }

    /**
     * Возвращает текстовый статус заказа
     *
     * @param   string      Статус
     * @return  string
     */
    public function order_status($status)
    {
        if (!isset($this->order_status[$status])) return NULL;
        return ($this->out_charset == self::CHARSET) ? $this->order_status[$status] : iconv(self::CHARSET, $this->out_charset, $this->order_status[$status]);
    }
}









//PHP 4.2.x Compatibility function
if (!function_exists('file_get_contents')) {
      function file_get_contents($filename, $incpath = false, $resource_context = null)
      {
          if (false === $fh = fopen($filename, 'rb', $incpath)) {
              trigger_error('file_get_contents() failed to open stream: No such file or directory', E_USER_WARNING);
              return false;
          }

          clearstatcache();
          if ($fsize = @filesize($filename)) {
              $data = fread($fh, $fsize);
          } else {
              $data = '';
              while (!feof($fh)) {
                  $data .= fread($fh, 8192);
              }
          }

          fclose($fh);
          return $data;
      }
}

if (!function_exists('json_encode')) {
    function json_encode( $array ){

    if( !is_array( $array ) ){
        return false;
    }

    $associative = count( array_diff( array_keys($array), array_keys( array_keys( $array )) ));
    if( $associative ){

        $construct = array();
        foreach( $array as $key => $value ){

            // We first copy each key/value pair into a staging array,
            // formatting each key and value properly as we go.

            // Format the key:
            if( is_numeric($key) ){
                $key = "key_$key";
            }
            $key = "'".addslashes($key)."'";

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "'".addslashes($value)."'";
            }

            // Add to staging array:
            $construct[] = "$key: $value";
        }

        // Then we collapse the staging array into the JSON form:
        $result = "{ " . implode( ", ", $construct ) . " }";

    } else { // If the array is a vector (not associative):

        $construct = array();
        foreach( $array as $value ){

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "'".addslashes($value)."'";
            }

            // Add to staging array:
            $construct[] = $value;
        }

        // Then we collapse the staging array into the JSON form:
        $result = "[ " . implode( ", ", $construct ) . " ]";
    }

    return $result;
}
}

if ( !function_exists('json_decode') ){
function json_decode($json)
{
    $comment = false;
    $out = '$x=';

    for ($i=0; $i<strlen($json); $i++)
    {
        if (!$comment)
        {
            if (($json[$i] == '{') || ($json[$i] == '['))       $out .= ' array(';
            else if (($json[$i] == '}') || ($json[$i] == ']'))   $out .= ')';
            else if ($json[$i] == ':')    $out .= '=>';
            else                         $out .= $json[$i];
        }
        else $out .= $json[$i];
        if ($json[$i] == '"' && $json[($i-1)]!="\\")    $comment = !$comment;
    }
    eval($out . ';');
    return $x;
}
}