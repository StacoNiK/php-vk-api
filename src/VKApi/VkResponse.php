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
}