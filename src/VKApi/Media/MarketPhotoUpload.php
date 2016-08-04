<?php namespace VKApi\Media;

class MarketPhotoUpload extends BasePhotoUpload
{
	public function __construct($vk, $photo_url, $params)
	{
		$this->upload_method = "photos.getMarketUploadServer";
		$this->key_filename = "file";
		parent::__construct($vk, $photo_url, $params);
	}

	public function save($params)
	{
		return $this->savePhoto($params, "photos.saveMarketPhoto");
	}
}