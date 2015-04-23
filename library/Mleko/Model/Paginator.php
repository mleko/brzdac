<?php

/**
 *
 * @author mleko
 */
class Abstract_Model_Paginator extends Zend_Paginator {

	public function getPaginatorArray() {
		return array(
			'page' => $this->getCurrentPageNumber(),
			'pageSize' => $this->getItemCountPerPage(),
			'itemCount' => $this->getTotalItemCount()
		);
	}

}

?>
