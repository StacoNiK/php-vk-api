<?php namespace VKApi;

class VkError
{
	public $error_code = 0;
	public $error_msg = "";
	public $request_params = [];
    public $error_array = [];

	public function __construct($jsonArray)
	{
		$this->error_code = $jsonArray["error_code"];
		$this->error_msg = $jsonArray["error_msg"];
		$this->request_params = $jsonArray["request_params"];
        $this->error_array = $jsonArray;
	}
}