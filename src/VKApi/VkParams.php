<?php namespace VKApi;

/**
 * @author Stas Pazhoha
 */

class VkParams
{
	protected $params = [];

	public function __construct($data = [])
	{
		$this->params = $data;
	}

	public function getParams()
	{
		return $this->params;
	}

	public function addParams($arr)
	{
		if (is_array($arr)) {
			$this->params = array_merge($this->params, $arr);
		}
	}

	public function get($key)
	{
		if (array_key_exists($key, $this->params)) {
			return $this->params[$key];
		}
	}

	public function set($key, $value)
	{
		$this->params[$key] = $value;
		return true;
	}

	public function delete($key)
	{
		if (array_key_exists($key, $this->params)) {
			unset($this->params[$key]);
		}
		return true;
	}

	public function existsParam($key)
	{
		return array_key_exists($key, $this->params);
	}

	public function addOffset($offset = 100)
	{
		$old_offset = 0;
		$offset = (int) $offset;
		if ($this->existsParam("offset")) {
			$old_offset = (int) $this->get("offset");
		}
		return $this->set("offset", $old_offset + $offset);
	}
}