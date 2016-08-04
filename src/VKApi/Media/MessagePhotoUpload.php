<?php namespace VKApi\Media;

class MessagePhotoUpload extends BasePhotoUpload
{
	public function __construct($vk, $photo_url, $params)
	{
		$this->upload_method = "photos.getMessagesUploadServer";
		$this->key_filename = "photo";
		parent::__construct($vk, $photo_url, $params);
	}

	public function save($params)
	{
		return $this->savePhoto($params, "photos.saveMessagesPhoto");
	}
}