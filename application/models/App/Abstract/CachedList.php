<?php

/**
 * Description of CachedList
 *
 * @author mleko
 */
abstract class App_Abstract_CachedList extends App_Abstract_List {

	/**
	 * @var Redis
	 */
	private $redis;
	protected $cache_expiration_time = 900; // 15 minutes
	protected $key_prefix = '_';
	public $cache_used = FALSE;
	protected $useCache = TRUE;

	public function __construct($key_prefix = '_', $cache_expiration_time = 900) {
		parent::__construct();
		$this->key_prefix = $key_prefix;
		$this->cache_expiration_time = $cache_expiration_time;
		try { $this->redis = App_Datastore::getRedis(); } catch(Exception $e) { $this->redis = null; }
	}

	public function GetData() {
		$key = $this->GetCacheKey();
		if($this->useCache && null !== $this->redis) {
			try { $val = $this->redis->get($key); } catch(Exception $e) { $val = false; }
			$this->cache_used = $val !== FALSE;
			if($val !== FALSE) { return igbinary_unserialize($val); }
		}
		$value = parent::GetData();
		if(null !== $this->redis) {
			try { $this->redis->setex($key, $this->cache_expiration_time, igbinary_serialize($value)); } catch(Exception $e) {

			}
		}
		return $value;
	}

	public function ClearCache() {
		try {
			if(null !== $this->redis) { $this->redis->del($this->GetCacheKey()); }
		} catch(Exception $e) {

		}
	}

	protected function GetCacheKey() {
		$key = $this->select->__toString();
		$key = $this->key_prefix . sha1($key) . md5($key);
		return $key;
	}

}
