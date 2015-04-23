<?php

define('SCRIPT_GENERATION_START', microtime(true));
$GLOBALS['bpoints'] = array();

function _D($label = '') {
    $db = debug_backtrace();
    $GLOBALS['bpoints'][] = array(microtime(true) - SCRIPT_GENERATION_START, $db[0]['file'], $db[0]['line'], $label);
}

_D('start');

// Define path to application directory
defined('APPLICATION_PATH')
	|| define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
	|| define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
	    realpath(APPLICATION_PATH . '/../library'),
	    get_include_path(),
	)));

    $blacklist = array();
    if (in_array($_SERVER['REMOTE_ADDR'], $blacklist)) {
	error_log(date('Y-m-d H:i:s') . " RICKNROLL: {$_SERVER['REMOTE_ADDR']}\n", 3, '/tmp/search.log');
	header('Location: http://www.youtube.com/watch?v=oHg5SJYRHA0&autoplay=1&loop=1#t=00m43s');
	exit();
    }

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
		APPLICATION_ENV,
		APPLICATION_PATH . '/configs/application.ini'
);
try {
    _D('pre boot');
    $application->bootstrap();
    _D('pre run');
    $application->run();
} catch (Exception $e) {
    print_r($e);
}

_D('end');
if (false)
    foreach ($GLOBALS['bpoints'] as $bp) {
	echo "<br/>\n{$bp[0]} - {$bp[1]}@{$bp[2]} -> {$bp[3]}";
    }
