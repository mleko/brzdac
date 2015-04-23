<?php

/**
 *
 * @author mleko
 */
abstract class Mleko_Model_List_Plugin {

	/**
	 * @return Abstract_Model_List_Extension[]
	 */
	protected function getRequiredExtensions() { return array(); }

	function extend(Mleko_Model_List_Template $list) {
		$extensions = $this->getRequiredExtensions();
		if(empty($extensions)) { return; }
		foreach($extensions as $extensionName) {
			if(!$list->hasExtension($extensionName)) {
				$extension = new $extensionName();
				$list->addExtension($extension);
			}
		}
	}

}
