<?php namespace VKApi;

/**
 * @author Stas Pazhoha
 */

class VkRequest
{
	public $attempts = 3;

	protected $http_client;
	protected $method;
	protected $params;
	protected $version;
	protected $access_token = false;

	protected $vk_error_listener = false;
	protected $success_listener = false;

	public function __construct($method, VkParams $params, $token = false)
	{
		$this->http_client = new Util\HttpClient();
		$this->method = (string) $method;
		$this->params = $params;
		if ($token instanceof VkAccessToken) {
			$this->access_token = $token;
		}
		$this->version = VkApi::getVersion();
	}

	public function execute($depth = 0)
	{
		$vkResult = new VkResult();
		if ($depth >= $this->attempts) {
			$vkResult->is_request_error = true;
			return $vkResult;
		}
		if (!$this->params->existsParam("v")) {
			$this->params->set("v", $this->version);
		}
		if ($this->access_token instanceof VkAccessToken) {
			if (!$this->params->existsParam("access_token")) {
				$this->params->set("access_token", $this->access_token->getToken());
			}
		}
		$builder = new RequestBuilder($this->method, $this->params);
		$requestStr = $builder->build();
		$response = $this->http_client->post($requestStr, $this->params->getParams());
		$jsonArray = json_decode($response, true);
		if (json_last_error() != JSON_ERROR_NONE) {
			$vkResult = $this->execute($depth+1);
		} else {
			if (array_key_exists("response", $jsonArray)) {
				$vkResponse = new VkResponse($jsonArray['response']);
				$vkResult->is_success = true;
				$vkResult->response = $vkResponse;
				if ($this->success_listener) {
					$listener = $this->success_listener;
					$listener($vkResponse);
				}
			} else if (array_key_exists("error", $jsonArray)) {
				if ($jsonArray['error']['error_code'] == 14) {
					$captcha = new VkCaptcha($jsonArray['error']['captcha_sid'], $jsonArray['error']['captcha_img']);
					$key = $captcha->getKey();
					if ($key) {
						$this->params->set("captcha_sid", $captcha->getSid());
						$this->params->set("captcha_key", $key);
						return $this->execute($depth+1);
					}
				}
				$vkError = new VkError($jsonArray['error']);
				VkApi::setLastError($vkError);
				$vkResult->is_error = true;
				$vkResult->error = $vkError;
				if ($this->vk_error_listener) {
					$listener = $this->vk_error_listener;
					$listener($vkError);
				}
			}
		}
		return $vkResult;
	}

	public function setVkErrorListener($func)
	{
		$this->vk_error_listener = $func;
	}

	public function setSuccessListener($func)
	{
		$this->success_listener = $func;
	}

	public function setVersion($version) 
	{
		$this->version = $version;
	}

	public function nextSelect()
	{
		$count = $this->params->getParam("count");
		if ($count) {
			$this->params->setParam("offset", $this->params->getParam("offset") + $count);
		}
	}
}