<?php namespace VKApi\Media;

/**
 * @author Stas Pazhoha
 */

class AlbumPhotoUpload extends BasePhotoUpload
{
	public function __construct($vk, $photo_url, $params)
	{
		$this->upload_method = "photos.getUploadServer,";
		$this->key_filename = "file1";
		parent::__construct($vk, $photo_url, $params);
	}

	public function save($params)
	{
		return $this->savePhoto($params, "photos.savePhoto");
	}
}