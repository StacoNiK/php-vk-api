<?php namespace VKApi;

class RequestBuilder 
{
	protected $method;
	protected $params;
	protected $api_url = "https://api.vk.com/method/";

	public function __construct($method, VkParams $params)
	{
		$this->method = $method;
		$this->params = $params;
	}

	public function build()
	{
		$string = $this->api_url.$this->method."?".http_build_query($this->params->getParams());
		return $string;
	}
}