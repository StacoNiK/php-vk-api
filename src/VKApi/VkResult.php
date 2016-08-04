<?php namespace VKApi;

class VkResult
{
	public $is_error = false;
	public $is_request_error = false;
	public $is_success = false;

	public $response;
	public $error;
}