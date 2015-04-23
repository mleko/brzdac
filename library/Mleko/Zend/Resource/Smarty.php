<?php

/**
 * Description of Plugin
 *
 * @author mleko
 */
class Mleko_Zend_Resource_Smarty extends Zend_Application_Resource_ResourceAbstract {

	/**
	 * @var Mleko_Zend_View_Smarty
	 */
	private $view = NULL;

	
	public function init() {
		return $this->getView();
	}
	
	private function getView(){
		if(is_null($this->view)) {
			$view = new Mleko_Zend_View_Smarty($this->getOptions());
			
			$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
			$viewRenderer->setViewSuffix('tpl');
			$viewRenderer->setView($view);
		}
		return $this->view;
	}

}

?>
