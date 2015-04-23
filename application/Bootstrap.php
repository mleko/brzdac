<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

	protected function _initAcl() {
		$acl = new Zend_Acl();

		$guestRole = new Zend_Acl_Role('guest');
		$userRole = new Zend_Acl_Role('user');
		$adminRole = new Zend_Acl_Role('admin');

		$acl->addRole($guestRole)
				->addRole($userRole, $guestRole)
				->addRole($adminRole, $userRole);

		$authorizedResource = new Zend_Acl_Resource('authorizedResource');
		$fileType = new Zend_Acl_Resource('fileType');
		$doodle = new Zend_Acl_Resource('doodle');

		$acl->addResource($authorizedResource);
		$acl->addResource($fileType);
		$acl->addResource($doodle);

		$acl->allow($userRole, $authorizedResource);

		$acl->allow($adminRole, $fileType);

		$acl->allow($adminRole, $doodle);

		Base_Acl::init($acl);
	}

	/**
	 * @return Zend_Controller_Router_Abstract
	 */
	protected function _initRoutes() {
		$this->bootstrap(array('frontController'));
		$frontController = $this->getResource('frontController');
		$routes = $this->getOption('routes');

		$router = $frontController->getRouter();
		if($routes) {
			foreach($routes as $name => $route) {
				$router->addRoute(
						$name,
						new Zend_Controller_Router_Route(
						$route['route'], isset($route['defaults']) ? $route['defaults'] : array(), isset($route['reqs']) ? $route['reqs'] : array()
						)
				);
			}
		}
		return $router;
	}

	protected function _initDatastore() {
		$config = new Zend_Config($this->getOption('datastore'));

		App_Datastore::init($config);
		Base_Datastore::init($config);
	}

}
