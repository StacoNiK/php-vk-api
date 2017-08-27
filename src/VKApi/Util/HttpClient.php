<?php namespace VKApi\Util;

class HttpClient
{
    protected $ch;
    protected static $instance;

    public function __construct()
    {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->ch, CURLOPT_POST, false);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
    }

    /**
     * Выполнение запроса
     */
    public function request($url, $data = false)
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        if (is_array($data)) {
            curl_setopt($this->ch, CURLOPT_POST, true);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
        } else {
            curl_setopt($this->ch, CURLOPT_POST, false);
        }
        return curl_exec($this->ch);
    }

    public function get($url)
    {
        return $this->request($url);
    }

    public function post($url, $data)
    {
        return $this->request($url, $data);
    }

    public function getResultUrl()
    {
        $info = curl_getinfo($this->ch);
        return $info['url'];
    }

    /**
     * Возвращает объект класса
     */
    public static function instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}