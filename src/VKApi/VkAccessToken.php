<?php namespace VKApi;

class VkAccessToken
{
	public $access_token = "";
	public $user_id = 0;
	public $expires_in = 0;

	public function __construct($data)
	{
		if (is_array($data)) {
			$this->access_token = $data['access_token'];
			$this->user_id = $data['user_id'];
			$this->expires_in = $data['expires_in'];
		} else {
			$this->access_token = $data;
		}
	}

	public function getToken()
	{
		return $this->access_token;
	}

	public function check()
	{
		$request = new VkRequest("users.get", new VkParams([]), $this);
		$result = $request->execute();
		if ($result->is_success) {
			$response = $result->response->get();
			if (array_key_exists(0, $response)) {
				return true;
			}
		}
		return false;
	}
}