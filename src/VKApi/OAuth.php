<?php namespace VKApi;

use \VKApi\Util\HttpClient;

class OAuth
{
	protected $params = [];
	protected $auth_url = "https://oauth.vk.com/authorize?";
	protected $auth_url_token = "https://oauth.vk.com/access_token?";

	public function __construct($params = [])
	{
		$this->params = [
				"response_type" => "token",
				"display" => "page",
				"v" => VkApi::getVersion(),
				"redirect_uri" => "https://oauth.vk.com/blank.html",
				"scope" => "wall,friends,groups,photos,offline"
			];
		if (!is_array($params)) {
			$this->params['client_id'] = (int) $params;
		} else {
			$this->params = array_merge($this->params, $params);
		}
	}

	public function getLink($params)
	{
		return $this->auth_url.http_build_query($params);
	}

	public function getImplictFlowLink()
	{
		$params = $this->params;
		$params['response_type'] = "token";
		if (array_key_exists("client_secret", $params)) {
			unset($params['client_secret']);
		}
		return $this->getLink($params);
	}

	public function getCodeLink()
	{
		$params = $this->params;
		$params['response_type'] = "code";
		if (array_key_exists("client_secret", $params)) {
			unset($params['client_secret']);
		}
		return $this->getLink($params);
	}

	public function getTokenByCode($code)
	{
		$params = [];
		$params['client_id'] = $this->params['client_id'];
		$params['client_secret'] = $this->params['client_secret'];
		$params['redirect_uri'] = $this->params['redirect_uri'];
		$params['code'] = $code;
		$url = $this->auth_url_token.http_build_query($params);
		$http = new HttpClient();
		$response = $http->get($url);
		$data = [];
		if ($response) {
			$data = json_decode($response, true);
		}
		if (array_key_exists("access_token", $data)) {
			return new VkAccessToken($data);
		} else {
			throw new Exception\AuthException($data['error']." - ".$data['error_description'], 1);
		}
		return false;
	}

	public function setParam($key, $value) 
	{
		$this->params[$key] = $value;
	}

	public function setAllScopes()
	{
		$this->params['scope'] = "notify,friends,photos,audio,video,docs,notes,pages,status,wall,groups,messages,email,notification,stats,market,offline";
	}
}