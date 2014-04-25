<?php

namespace Application\Controller;

use Core\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Application\Model\DocumentType;
use Application\Form\NewDocument;
use Application\Model\Document;

class DocumentController extends ActionController {

    protected $documentTable;

    protected function getDocumentTable() {

        if (!$this->documentTable) {
            $sm = $this->getServiceLocator();
            $this->documentTable = $sm->get('Application\Model\DocumentTable');
        }
        return $this->documentTable;
    }

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
            $session = $sm->get('Session');
            $user = $session->offsetGet('user');
            $form->setData($request->getPost());
            if ($form->isValid()) {
                // TODO - store timezone of user
                $date = new \DateTime('now', new \DateTimeZone('America/Fortaleza'));
                
                $params = array(
                    'name' => $form->getInputFilter()->getValue('name'),
                    'owner' => $user->id,
                    'document_type_id' => $type_id,
                    'created_at' => $date->format('Y-m-d H:i:s.u'),
                );
                $conn = $sm->get("Zend\Db\Adapter\Adapter")->getDriver()->getConnection();
                $conn->beginTransaction();
                try {
                    $id = $this->getDocumentTable()->create($params);

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
        $doc = $this->getDocumentTable()->getDocument($id);
//        $sm = $this->getServiceLocator();
//        $session = $sm->get('Session');
//        $user = $session->offsetGet('user');
//        
//        if ($user->id != $doc->owner) {
//            return $this->redirect()->toUrl('/application/preview/id/'.$id);
//        }

        return new ViewModel(array(
            'id' => $id,
            'doc' => $doc,
        ));
    }

    /**
     * Mapped as
     *    /d/:id/export[/:type]
     * @return \Zend\View\Model\ViewModel
     */
    public function exportAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        $type = $this->params()->fromRoute('type', 'pdf');
        if (!in_array($type, array('pdf', 'html'))) {
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
        $id = (int) $this->params()->fromRoute('id', 0);
        $doc = $this->getDocumentTable()->getDocument($id);
        $document = new Document();
        $document->exchangeArray($doc);
        echo "<pre>";
        var_dump($document->toArray());
        echo "</pre>";
        
    }

    public function ajaxSaveAction() {
        $data = array();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $this->params()->fromPost();
            $this->getDocumentTable()->save($data);
        }
        
        return new JsonModel(array(
            'message' => "asdasdasd",
        ));
    }
    
    public function previewAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        $doc = $this->getDocumentTable()->getDocument($id);
        
        $parse = new \Parsedown();
        $md = $parse->parse($doc->content);
        
        $sm = $this->getServiceLocator();
        $session = $sm->get('Session');
        $user = $session->offsetGet('user');
        
        $checkOwner = $user->id === $doc->owner;
        
        $format = $this->params()->fromRoute('format', 'html');
        if ($format === 'json') {
            $viewModel = new JsonModel();
        } else {
            $viewModel = new ViewModel();
        }
        
        return $viewModel->setVariables(
            array(
                'id' => $doc->id,
                'name' => $doc->name,
                'content' => $md,
                'checkOwner' => $checkOwner,
            )
        );
    }

}