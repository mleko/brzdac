<?php

/*
 * Log.php
 * Created on 2011-08-11 21:21:05 by kefir
 * 
 */

class Mleko_Log {

    static private $logger;
    static public $log_level = Zend_Log::DEBUG;
    static public $toSTD = FALSE;

    static protected function init() {
	$logger = new Zend_Log();

	$file_writer_debug = new Zend_Log_Writer_Stream(APPLICATION_PATH . "/../log/debug.log");
	$logger->addWriter($file_writer_debug);

	$file_writer_info = new Zend_Log_Writer_Stream(APPLICATION_PATH . "/../log/info.log");
	$filter = new Zend_Log_Filter_Priority(Zend_Log::INFO);
	$file_writer_info->addFilter($filter);
	$logger->addWriter($file_writer_info);

	$file_writer_warn = new Zend_Log_Writer_Stream(APPLICATION_PATH . "/../log/warn.log");
	$file_writer_warn->addFilter(new Zend_Log_Filter_Priority(Zend_Log::WARN));
	$logger->addWriter($file_writer_warn);

	$file_writer_error = new Zend_Log_Writer_Stream(APPLICATION_PATH . "/../log/error.log");
	$filter = new Zend_Log_Filter_Priority(Zend_Log::ERR);
	$file_writer_error->addFilter($filter);
	$logger->addWriter($file_writer_error);

	$file_writer_wtf = new Zend_Log_Writer_Stream(APPLICATION_PATH . "/../log/wtf.log");
	$filter = new Zend_Log_Filter_Priority(Zend_Log::EMERG);
	$file_writer_wtf->addFilter($filter);
	$logger->addWriter($file_writer_wtf);

	//$firebug_writer = new Zend_Log_Writer_Firebug();
	//$logger->addWriter($firebug_writer);
	self::$logger = $logger;
    }

    static function log($item, $level = 7, $trace_step = 0) {
	if (self::$log_level !== NULL && self::$log_level < $level)
	    return;
	if (!isset(self::$logger))
	    self::init();
	$dbgbt = debug_backtrace();
	$dbg = $dbgbt[$trace_step];
	$header = $dbg['file'] . "@" . $dbg['line'] . "# ";
	if (is_string($item) || is_numeric($item)) {
	    $msg = $header . $item;
	} else if ($item === NULL && isset($dbgbt[$trace_step + 1])) {
	    $msg = "$header {$dbg['class']}{$dbgbt[$trace_step + 1]['type']}{$dbgbt[$trace_step + 1]['function']}";
	} else {
	    $msg = $header . print_r($item, true);
	}
	if (self::$toSTD)
	    echo $msg;
	self::$logger->log($msg, $level);
    }

    static function dbg($item = NULL) {
	self::log($item, Zend_Log::DEBUG, 1);
    }

    static function info($item) {
	self::log($item, Zend_Log::INFO, 1);
    }

    static function warn($item) {
	self::log($item, Zend_Log::WARN, 1);
    }

    static function err($item) {
	self::log($item, Zend_Log::ERR, 1);
    }

    static function wtf($item) {
	self::log($item, Zend_Log::EMERG, 1);
    }

    static function ddbg($item) {
	if (defined('DEBUG'))
	    self::log($item, Zend_Log::DEBUG, 1);
    }

}

?>
