<?php

namespace Admin\Controller;

use Admin\Filter\EditOfferFilter;
use Admin\Filter\EditWorkerFilter;
use Admin\Form\EditOfferForm;
use Admin\Form\EditWorkerForm;
use Application\Model\Offer;
use Application\Model\OfferTable;
use Admin\Filter\EditUserFilter;
use Admin\Form\EditUserForm;
use Application\Model\Worker;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Helper\GridHelper;
use Zend\Crypt\Password\Bcrypt;

class WorkerController extends AbstractActionController
{
    public function __construct()
    {

    }

    /**
     *
     * @return Application\Model\WorkerTable
     */
    private function getWorkerTable()
    {
        if(!isset($this->workerTable))
        {
            $sm = $this->getServiceLocator();
            $this->workerTable = $sm->get('Application\Model\WorkerTable');
        }
        return $this->workerTable;
    }

    private function getTranslator()
    {
        if(!isset($this->translator))
        {
            $this->translator = $this->getServiceLocator()->get('Translator');
        }
        return $this->translator;
    }

    public function indexAction()
    {
        //new table helper
        $tableHelper = new GridHelper($this->getServiceLocator()->get('WorkerTableGateway'));
        $table = $tableHelper->getHtml(
            array('aliases'         =>  array('location'            =>  'Location',
                                              'ws1'                 =>  'Webservice file',
                                              'ws2'                 =>  'Webservice download',
                                              'last_update'         =>  'Last update',
                                              'date_creation'       =>  'Creation date',
                                              'free_space_bytes'    =>  'Free space',
                                              'used_space_bytes'    =>  'Used space',
                                              'status'              =>  'Status'
                                             ),

                  'dataFormatter'   =>  array('date_creation'       =>'dateFromTimestamp',
                                              'last_update'         =>'dateFromTimestamp'
                                             ),

                  'filterOut'       =>  array('count'),

                  'baseUrl'         => $this->url()->fromRoute('adminWorker'),

                  'editUrl'         => $this->url()->fromRoute('editWorker',array('id' => ':s')),

                  'enableDelete'    => false,
                 ));

        return new ViewModel(array('table' => $table));
    }


    public function newAction()
    {
        $editWorkerFilter = new EditWorkerFilter($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $form = new EditWorkerForm();
        if($this->getRequest()->isPost()) {
            $form->setInputFilter($editWorkerFilter->getInputFilter());
            $form->setData($this->getRequest()->getPost());

            if($form->isValid())
            {
                $worker = new Worker();
                $worker->exchangeRow($this->getRequest()->getPost());
                $data = $worker->returnArray(array('count'));
                $data['date_creation']      = time();
                $data['free_space_bytes']   = 0;
                $data['used_space_bytes']   = 0;
                $data['last_update']        = 0;
                $data['status']             = 'down';
                $this->getWorkerTable()->insert($data);
                $this->flashmessenger()->addInfoMessage($this->getTranslator()->translate('The worker has been added.'));
                $this->redirect()->toRoute('adminWorker');
            }
        }
        else
        {
            $form->setInputFilter($editWorkerFilter->getInputFilter());
        }
        return new ViewModel(array('form' => $form));
    }

    public function editAction()
    {

        $editOfferFilter = new EditWorkerFilter($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $form = new EditWorkerForm();
        if($this->getRequest()->isPost()) {
            $form->setInputFilter($editOfferFilter->getInputFilter());
            $form->setData($this->getRequest()->getPost());

            if($form->isValid())
            {
                $offer = new Worker();
                $offer->exchangeRow($this->getRequest()->getPost());
                $filterOut = array('date_creation',
                                   'free_space_bytes',
                                   'used_space_bytes',
                                   'last_update',
				                   'count',
                                   'status');
                $data = $offer->returnArray($filterOut);
                $this->getWorkerTable()->update($data, array('id' => (int)$this->params()->fromRoute('id')));
                $this->flashmessenger()->addInfoMessage($this->getTranslator()->translate('The worker has been edited.'));
                $this->redirect()->toRoute('adminWorker');
            }
        }
        else
        {
            $form->setInputFilter($editOfferFilter->getInputFilter());
            $form->setData($userData = $this->getWorkerTable()->getWorkerArray($this->params()->fromRoute('id')));
        }
        return new ViewModel(array('form' => $form));
    }
}
