<?php namespace VKApi;

class VkResponse
{
	public $responseArray = [];

	public function __construct($jsonArray)
	{
		$this->responseArray = $jsonArray;
	}

	public function get()
	{
		return $this->responseArray;
	}
	
	public function __get($name)
	{
		return $this->responseArray[$name];
	}
}
}
