<?php namespace VKApi;

class VkCaptcha
{
	protected $captcha_sid = 0;
	protected $captcha_img = "";
	protected $captcha_key = "";

	public function __construct($sid, $img)
	{
		$this->captcha_sid = $sid;
		$this->captcha_img = $img;
	}

	public function getSid()
	{
		return $this->captcha_sid;
	}

	public function getImgUrl()
	{
		return $this->captcha_img;
	}

	public function getKey($key)
	{
		$handler = VkApi::getCaptchaHandler();
		$result = false;
		if ($handler) {
			$result = $handler->getCaptchaKey($this);
		}
		return $result;
	}
}