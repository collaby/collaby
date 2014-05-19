<?php

namespace Admin\Controller;

use Core\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Admin\Form\Template;
use Admin\Form\TemplateFilter;
use Admin\Model\AdminTemplateTable;

/**
 * Description of TemplateController
 *
 * @author atila
 */
class TemplateController extends ActionController {
    
    public function indexAction() {
        $sm = $this->getServiceLocator();
        $model = $sm->get('Admin\Model\AdminTemplateTable');
        $list = $model->listAll();
        
        return new ViewModel(array(
            'list' => $list
        ));
    }
    
    public function saveAction() {
        $form = new Template();
        $request = $this->getRequest();
        $id = (int) $this->params()->fromRoute('id', 0);
        $sm = $this->getServiceLocator();
        $model = $sm->get('Admin\Model\AdminTemplateTable');
        
        if ($request->isPost()) {
            $inputFilter = new TemplateFilter();
            $form->setInputFilter($inputFilter->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                unset($data['submit']);
                // TODO surround with try catch
                if ($id > 0) {
                    $model->update($data, $id);
                } else {
                    $model->create($data);
                }
                $this->redirect()->toRoute('dashboard_template');
            }
        } else {
            if ($id > 0) {
                $title = 'Edit Template';
                try {
                    $values = $model->read($id);
                    $form->bind($values);
                } catch (\Exception $e) {
                    $this->messages()->flashError($e->getMessage());
                    $this->redirect()->toRoute('dashboard_template');
                }
            } else {
                $title = 'New Template';
            }
        }
        
        return new ViewModel(array(
           'form' => $form,
            'title' => $title
        ));
    }
}
