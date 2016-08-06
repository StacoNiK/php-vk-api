<?php namespace VKApi\Method;

class Execute
{
	protected $vk;

	public function __construct(\VKApi\VKApi $vk)
	{
		$this->vk = $vk;
	}

	public function getWall(\VKApi\VkParams $params, $iters = 25)
	{
		$template = $this->loadTemplate("wall_execute");
		if (!$template) {
			return false;
		}
		$params->set("code", $template);
		$params->set("iters", $iters);
		$request = $this->vk->createRequest("execute", $params);
		$response = $request->execute();
		if (!$response->is_success) {
			return false;
		}
		$items = $response->response->get();
		$result = [];
		foreach ($items as $item) {
			if (is_array($item)) {
				$result = array_merge($result, $item);
			}
		}
		return $result;
	}

	public function getGroupMembers(\VKApi\VkParams $params, $iters = 25)
	{
		$template = $this->loadTemplate("members_execute");
		if (!$template) {
			return false;
		}
		$params->set("code", $template);
		$params->set("iters", $iters);
		$request = $this->vk->createRequest("execute", $params);
		$response = $request->execute();
		if (!$response->is_success) {
			return false;
		}
		$items = $response->response->get();
		$result = [];
		foreach ($items as $item) {
			if (is_array($item)) {
				$result = array_merge($result, $item);
			}
		}
		return $result;
	}

	public function getWallComments(\VKApi\VkParams $params, $iters = 25)
	{
		$template = $this->loadTemplate("comment_execute");
		if (!$template) {
			return false;
		}
		$params->set("code", $template);
		$params->set("iters", $iters);
		$request = $this->vk->createRequest("execute", $params);
		$response = $request->execute();
		if (!$response->is_success) {
			return false;
		}
		$items = $response->response->get();
		$result = [];
		foreach ($items as $item) {
			if (is_array($item)) {
				$result = array_merge($result, $item);
			}
		}
		return $result;
	}

	public function getLikesList(\VKApi\VkParams $params, $iters = 25)
	{
		$template = $this->loadTemplate("likes_list_execute");
		if (!$template) {
			return false;
		}
		$params->set("code", $template);
		$params->set("iters", $iters);
		$request = $this->vk->createRequest("execute", $params);
		$response = $request->execute();
		if (!$response->is_success) {
			return false;
		}
		$items = $response->response->get();
		$result = [];
		foreach ($items as $item) {
			if (is_array($item)) {
				$result = array_merge($result, $item);
			}
		}
		return $result;
	}

	protected function loadTemplate($name)
	{
		$path = __DIR__."/../templates/".$name.".txt";
		if (file_exists($path)) {
			return file_get_contents($path);
		}
		return false;
	}
}