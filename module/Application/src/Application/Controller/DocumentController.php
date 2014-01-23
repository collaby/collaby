<?php

namespace Application\Controller;

use Core\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Application\Model\DocumentType;
use Application\Form\NewDocument;

class DocumentController extends ActionController {
	
   /**
    * Mapped as
    *    /new[/:type]
    * @return \Zend\View\Model\ViewModel
    */
	public function newAction() {
		$type = $this->params()->fromRoute('type', 'latex');
		// TODO: criar documento, obter id, redirecionar para modo de edição do documento.
        switch ($type) {
            case 'latex':
                $type_id = DocumentType::latex;
                break;
            case 'beamer':
                $type_id = DocumentType::beamer;
                break;
            default: // fallback to latex
                $type_id = DocumentType::latex;
        }

        $sm = $this->getServiceLocator();
        $modelTemplates = $sm->get('Application\Model\TemplateTable');
        $form = new NewDocument($modelTemplates, $type_id);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $modelDocument = $sm->get('Application\Model\DocumentTable');
            $session = $sm->get('Session');
            $user = $session->offsetGet('user');
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $params = array(
                    'name' => $form->getInputFilter()->getValue('name'),
                    'owner' => $user->id,
                    'document_type_id' => $type_id,
                );
                $conn = $sm->get("Zend\Db\Adapter\Adapter")->getDriver()->getConnection();
                $conn->beginTransaction();
                try {
                    $id = $modelDocument->create($params);

                    $modelDocumentTemplate = $sm->get('Application\Model\DocumentTemplateTable');
                    $modelDocumentTemplate->create($id, $form->get('original_template_id')->getValue());

                    $conn->commit();
                    $this->redirect()->toRoute('edit-document', array('id' => $id));
                } catch (\Exception $e) {
                    $conn->rollback();
                    $this->messages()->flashError('Unespected error. ' . $e->getMessage());
                }
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }

    /**
    * Mapped as
    *    /d/:id
    * @return \Zend\View\Model\ViewModel
    */
	public function editAction() {
		$id = (int) $this->params()->fromRoute('id', 0);
		return new ViewModel(array('id' => $id));
	}

   /**
    * Mapped as
    *    /d/:id/export[/:type]
    * @return \Zend\View\Model\ViewModel
    */
	public function exportAction() {
		$id = (int) $this->params()->fromRoute('id', 0);
		$type = $this->params()->fromRoute('type', 'pdf');
		if (! in_array($type, array('pdf', 'html'))) {
			$this->messages()->flashWarning('Export type not found.');
			return $this->redirect()->toUrl('/');
		}
		return new ViewModel(array('id' => $id, 'type' => $type));
	}

   /**
    * Mapped as
    *    /import
    */
	public function importAction() {
		// TODO: upload markdown/text file
	}
   
   /**
    * Mapped as
    *    /clone/:id
    */
   public function cloneAction() {
      // TODO: clone the document and redirect to edit
   }
}