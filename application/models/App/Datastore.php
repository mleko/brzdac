<?php

/**
 * Description of Datastore
 *
 * @author mleko
 */
class App_Datastore {

    /**
     * @var Zend_Config | FALSE
     */
    private static $config = FALSE;

    /**
     * @var Zend_Db_Adapter_Abstract | FALSE
     */
    private static $mysql = FALSE;

    /**
     * @var Redis | FALSE
     */
    private static $redis = FALSE;

    /**
     * @var Zend_Db_Adapter_Abstract | FALSE
     */
    private static $sphinx = FALSE;

    public static function init($config) {
	static::$config = $config;
    }

    /**
     * @return Redis | NULL
     * @throws Exception
     */
    public static function getRedis() {
	if (FALSE === static::$redis) {
	    if (FALSE === static::$config)
		throw new Exception('Init Datastore first');
	    $redis = new Redis();
	    $redis->pconnect(static::$config->redis->host, static::$config->redis->port);
	    static::$redis = $redis;
	}
	return static::$redis;
    }

    /**
     * @return Zend_Db_Adapter_Abstract
     * @throws Exception
     */
    public static function getSphinx() {
	if (FALSE === static::$sphinx) {
	    if (FALSE === static::$config)
		throw new Exception('Init Datastore first');
	    static::$sphinx = Zend_db::factory(self::$config->sphinx);
	}
	return static::$sphinx;
    }

    /**
     * @return Zend_Db_Adapter_Abstract
     * @throws Exception
     */
    public static function getMySQL() {
	if (FALSE === static::$mysql) {
	    if (FALSE === static::$config)
		throw new Exception('Init Datastore first');
	    static::$mysql = Zend_db::factory(self::$config->mysql);
	}
	return static::$mysql;
    }

}

?>
