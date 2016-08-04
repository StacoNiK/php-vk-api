<?php namespace VKApi\Media;

class WallPhotoUpload extends BasePhotoUpload
{
	public function __construct($vk, $photo_url, $params)
	{
		$this->upload_method = "photos.getChatUploadServer";
		$this->key_filename = "file";
		parent::__construct($vk, $photo_url, $params);
	}

	public function save($params)
	{
		return $this->savePhoto($params, "messages.setChatPhoto");
	}
}