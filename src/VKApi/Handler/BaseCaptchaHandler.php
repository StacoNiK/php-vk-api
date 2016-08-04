<?php namespace VKApi\Handler;

abstract class BaseCaptchaHandler
{
	abstract public function getCaptchaKey($vkCaptcha);
}