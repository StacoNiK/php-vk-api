<?php namespace VKApi;

class VkApi
{
	public static $version = "5.53";
	protected static $captcha_handler; 
	protected static $is_captcha_handler = false;

	protected $access_token = false;

	public static function getVersion()
	{
		return self::$version;
	}

	public static function setVersion($v)
	{
		self::$version = $v;
	}

	public static function setCaptchaHandler(Handler\BaseCaptchaHandler $handler)
	{
		$this->captcha_handler = $handler;
		$this->is_captcha_handler = true;
	}

	public static function getCaptchaHandler()
	{
		if ($this->is_captcha_handler) {
			return $this->captcha_handler;
		}
		return false;
	}

	public function __construct($token = null)
	{
		if ($token instanceof VkAccessToken) {
			$this->access_token = $token;
		}
	}

	public function getToken()
	{
		return $this->access_token;
	}

	public function createRequest($method, $params)
	{
		return new VkRequest($method, $params, $this->access_token);
	}
}