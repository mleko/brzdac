<?php

class Search_ErrorController extends Zend_Controller_Action {

	public function errorAction() {
		$errors = $this->_getParam('error_handler');

		switch($errors->type) {
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:

				// 404 error -- controller or action not found
				$this->getResponse()->setHttpResponseCode(404);
				$this->view->message = 'Page not found';
				$this->view->img = 'notfound';

				Mleko_Log::err($this->view->message);
				break;
			default:
				// application error
				$this->getResponse()->setHttpResponseCode(500);
				$this->view->message = 'Application error';
				$this->view->img = 'syserror';

				Mleko_Log::err($this->view->message);
				//Mleko_Log::err($errors->exception);
				break;
		}

		// conditionally display exceptions
		if($this->getInvokeArg('displayExceptions') == true) {
			$this->view->exception = $errors->exception;
		}

		$this->view->request = $errors->request;
	}

	public function getLog() {
		$bootstrap = $this->getInvokeArg('bootstrap');
		if(!$bootstrap->hasPluginResource('Log')) {
			return false;
		}
		$log = $bootstrap->getResource('Log');
		return $log;
	}

}
