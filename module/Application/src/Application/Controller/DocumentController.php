<?php

namespace Application\Controller;

use Core\Controller\ActionController;
use Zend\View\Model\ViewModel;

class DocumentController extends ActionController {
	
	public function newAction() {
		$type = $this->params()->fromRoute('type', 'latex');
		if (! in_array($type, array('latex', 'beamer'))) {
			$this->messages()->flashWarning('Export type not found.');
			return $this->redirect()->toUrl('/');
		}
		// TODO: criar documento, obter id, redirecionar para modo de edição do documento.
		// esta action não deve ter view.
		return new ViewModel(array('type' => $type));
	}

	public function editAction() {
		$id = (int) $this->params()->fromRoute('id', 0);
		return new ViewModel(array('id' => $id));
	}

	public function exportAction() {
		$id = (int) $this->params()->fromRoute('id', 0);
		$type = $this->params()->fromRoute('type', 'pdf');
		if (! in_array($type, array('pdf', 'html'))) {
			$this->messages()->flashWarning('Export type not found.');
			return $this->redirect()->toUrl('/');
		}
		return new ViewModel(array('id' => $id, 'type' => $type));
	}

	public function importAction() {
		// TODO: upload markdown/text file
	}
}