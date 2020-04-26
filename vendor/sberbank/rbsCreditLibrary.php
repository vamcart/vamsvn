<?php

define('RBS_PROD_URL_C' , 'https://securepayments.sberbank.ru/sbercredit/');
define('RBS_TEST_URL_C' , 'https://3dsec.sberbank.ru/sbercredit/');
define('RBS_PROD_URL' , 'https://securepayments.sberbank.ru/payment/rest/');
define('RBS_TEST_URL' , 'https://3dsec.sberbank.ru/payment/rest/');


/**
 * Интеграция платежного шлюза RBS с OpenCart
 */
class RBSCreditLibrary {

    /** @var string $language   Версия страницы оплаты*/
    private $language = 'ru';

    private $defaultMeasurement = "шт";

    /** @var string $version    Версия плагина*/
    private $version = 'CRD 0.0.2';

    /** @var string $login      Логин продавца*/
    private $login;

    /** @var string $password   Пароль продавца */
    private $password;

    /** @var string $mode       Режим работы модуля (test/prod) */
    private $mode;

    /** @var string $stage      Стадийность платежа (one/two) */
    private $stage;

    /** @var boolean $logging   Логгирование (1/0) */
    private $logging;

    /** @var string $currency   Числовой код валюты в ISO 4217 */
    private $currency;

    private $ofd_status;
    private $ffd_version;
    private $paymentMethodType;
    private $paymentObjectType;

    /** @var integer $taxSystem  Код системы налогообложения */
    public $taxSystem;
    public $taxType;

    public $returnUrl;
    public $failUrl;

    /**
     * @return mixed
     */
    public function getFFDVersion()
    {
        return $this->ffd_version;
    }

    /**
     * @return mixed
     */
    public function getPaymentMethodType()
    {
        return $this->paymentMethodType;
    }

    /**
     * @return mixed
     */
    public function getPaymentObjectType()
    {
        return $this->paymentObjectType;
    }

    /**
     * @return string
     */
    public function getDefaultMeasurement()
    {
        return $this->defaultMeasurement;
    }


    /**
     * Магический метод, который заполняет инстанс
     *
     * @param $property
     * @param $value
     * @return $this
     */
    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
        return $this;
    }

    /**
     * Формирование запроса в платежный шлюз и парсинг JSON-ответа
     *
     * @param string $method Метод запроса в ПШ
     * @param mixed[] $args Данные в запросе
     * @param $check
     * @return mixed[]
     */
    private function gateway($method, $args, $check = false) {

        // Добавления логина и пароля продавца к каждому запросу
        $args['userName'] = $this->login;
        $args['password'] = $this->password;
        $args['language'] = $this->language;

        // Выбор адреса ПШ в зависимости от выбранного режима
        if ($this->mode == 'test') {
            $url = ($check == false) ? RBS_TEST_URL_C : RBS_TEST_URL;
            $args['dummy'] = 1;
        } else {
            $url = ($check == false) ? RBS_PROD_URL_C : RBS_PROD_URL;
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url.$method,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POSTFIELDS => http_build_query($args, '', '&'),
            CURLOPT_HTTPHEADER => array('CMS: OpenCart 3.x', 'Module-Version: ' . $this->version),
        ));

        $response = curl_exec($curl);

        if ($this->logging) {
            $this->logger($url, $method, $args, $response);
        }

        $response = json_decode($response, true);
        curl_close($curl);

        return $response;
    }

    /**
     * Логирование запроса и ответа от ПШ
     *
     * @param string $url
     * @param string $method
     * @param mixed[] $request
     * @param mixed[] $response
     * @return integer
     */
    private function logger($url, $method, $request, $response) {
        $this->library('log');
        $logger = new Log('rbs_credit.log');
        $logger->write("RBS CREDIT: ".$url.$method."\nREQUEST: ".json_encode($request). "\nRESPONSE: ".$response."\n\n");
    }

    /**
     * Регистрация заказа в ПШ
     *
     * @param string $order_number Номер заказа в магазине
     * @param integer $amount Сумма заказа
     * @param string $return_url Страница в магазине, на которую необходимо вернуть пользователя
     * @param $customer_phone
     * @param null $orderBundle
     * @return mixed[] Ответ ПШ
     */
    public function register_order($order_number, $amount, $return_url, $customer_phone, $orderBundle = null) {

        $data = array(
            'orderNumber' => $order_number . "_". time(),
            'amount' => $amount,
            'jsonParams' => json_encode(
                [
                    'CMS:' => 'Opencart 3.x',
                    'Module-Version: ' =>  $this->version,
                    'phone' => $customer_phone
                ]
            ),
        );

        //returnUrl must be
        $data['returnUrl'] = !empty($this->returnUrl) ? $this->returnUrl : $return_url;

        //failUrn if exists
        if (!empty($this->failUrl)) {
            $data['failUrl'] = $this->failUrl;
        }

        if ($this->currency != 0) {
            $data['currency'] = $this->currency;
        }

        if (!empty($orderBundle)) {
            $data['taxSystem'] = $this->taxSystem;

            $data['orderBundle']['orderCreationDate'] = date('c');
            $data['orderBundle'] = json_encode($orderBundle);
        }

        return $this->gateway('register.do', $data);
    }

    /**
     * Статус заказа в ПШ
     *
     * @param string $orderId Идентификатор заказа в ПШ
     * @return mixed[] Ответ ПШ
     */
    public function get_order_status($orderId) {
        return $this->gateway('getOrderStatusExtended.do', array('orderId' => $orderId), true);
    }

    /**
     * В версии 2.1 нет метода Loader::library()
     * Своя реализация
     * @param $library
     */
    private function library($library) {
        $file = DIR_SYSTEM . 'library/' . str_replace('../', '', (string)$library) . '.php';

        if (file_exists($file)) {
            include_once($file);
        } else {
            trigger_error('Error: Could not load library ' . $file . '!');
            exit();
        }
    }
}