<?php namespace VKApi\Media;

/**
 * @author Stas Pazhoha
 */

abstract class BasePhotoUpload
{
	protected $http;
	protected $vk;
	protected $upload_server;
	protected $upload_method;
	protected $photo_url;
	protected $key_filename = "file1";
	protected $upload_result;

	public function __construct($vk, $photo_url, $upload_params)
	{
		$this->http = new \VKApi\Util\HttpClient();
		$this->vk = $vk;
		$this->photo_url = $photo_url;
		$this->upload_server = $this->getUploadServer($upload_params);
		$this->upload_result = $this->uploadPhoto();
	}

	abstract public function save($params);

	protected function savePhoto($params, $method)
	{
		$params->addParams($this->upload_result);
		$request = $this->vk->createRequest($method, $params);
		$result = $request->execute();
		if ($result->is_success) {
			$items = $result->response->get();
			return $items;
		} else {
			throw new \VKApi\Exception\UploadException($result->error->error_msg, 1);
			return false;
		}
	}

	protected function getUploadServer($params)
	{
		$request = $this->vk->createRequest($this->upload_method, $params);
		$result = $request->execute();
		if ($result->is_success) {
			return $result->response;
		} else {
			throw new \VKApi\Exception\UploadException($result->error->error_msg, 1);
			return false;
		}
	}

	protected function uploadPhoto()
	{
		$photo = $this->http->get($this->photo_url);
		$rand_name = mt_rand(1, 560234).mt_rand(560234, 760234).mt_rand(760234, 999999).".jpg";
		file_put_contents($rand_name, $photo);
        if (version_compare(PHP_VERSION, '5.5.0', '<=')) {
            $params = [$this->key_filename => "@".$rand_name];
        } else {
        	$file = new \CURLFile($rand_name);
			$params = [$this->key_filename => $file];
        }
		$response = $this->http->post($this->upload_server->get()['upload_url'], $params);
		unlink($rand_name);
		$data = json_decode($response, true);
		return $data;
	}
}