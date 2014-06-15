<?php

namespace Admin\Controller;

use Admin\Filter\EditOfferFilter;
use Admin\Form\EditOfferForm;
use Application\Model\Offer;
use Application\Model\OfferTable;
use Admin\Filter\EditUserFilter;
use Admin\Form\EditUserForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Helper\GridHelper;
use Zend\Crypt\Password\Bcrypt;

class OfferController extends AbstractActionController
{
    public function __construct()
    {

    }

    /**
     *
     * @return Application\Model\OfferTable
     */
    private function getOfferTable()
    {
        if(!isset($this->userTable))
        {
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('Application\Model\OfferTable');
        }
        return $this->userTable;
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
        $tableHelper = new GridHelper($this->getServiceLocator()->get('OfferTableGateway'));
        $table = $tableHelper->getHtml(
            array('aliases'         =>  array('position_priority'       =>  'Priority-position',
                                              'title'                   =>  'Title',
                                              'month_price'             =>  'Price/month',
                                              'size_go'                 =>  'Max Space',
                                              'maximum_upload_speed'    =>  'Upload bandwidth',
                                              'maximum_download_speed'  =>  'Download bandwidth',
                                              'date_creation'           =>  'Creation date',
                                              'date_last_edit'          =>  'Last edit'
                                             ),

                  'dataFormatter'   =>  array('date_creation'       =>'dateFromTimestamp',
                                              'date_last_edit'    =>'dateFromTimestamp',
                                             ),


                  'filterOut'       =>  array('id','short_description','long_description'),

                  'baseUrl'         =>  $this->url()->fromRoute('adminOffer'),

                  'editUrl'         => $this->url()->fromRoute('editOffer',array('id' => ':s')),

                  'enableDelete'    => false,
                 ));
        return new ViewModel(array('table' => $table));
    }


    public function newAction()
    {
        $editOfferFilter = new EditOfferFilter($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $form = new EditOfferForm();
        if($this->getRequest()->isPost()) {
            $form->setInputFilter($editOfferFilter->getInputFilter());
            $form->setData($this->getRequest()->getPost());

            if($form->isValid())
            {
                $offer = new Offer();
                $offer->exchangeRow($this->getRequest()->getPost());
                $data = $offer->returnArray();
                $data['date_creation'] = time();
                $data['date_last_edit'] = time();
                $this->getOfferTable()->insert($data);
                $this->flashmessenger()->addInfoMessage($this->getTranslator()->translate('The offer has been created.'));
                $this->redirect()->toRoute('adminOffer');
            }
        }
        else
        {
            $form->setInputFilter($editOfferFilter->getInputFilter());
        }
        return new ViewModel(array('form' => $form));
    }

    public function editAction()
    {

        $editOfferFilter = new EditOfferFilter($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $form = new EditOfferForm();
        if($this->getRequest()->isPost()) {
            $form->setInputFilter($editOfferFilter->getInputFilter());
            $form->setData($this->getRequest()->getPost());

            if($form->isValid())
            {
                $offer = new Offer();
                $offer->exchangeRow($this->getRequest()->getPost());
                $filterOut = array('date_creation');
                $data = $offer->returnArray($filterOut);
                $data['date_last_edit'] = time();
                $this->getOfferTable()->update($data, 'id = \''.$this->params()->fromRoute('id').'\'');
                $this->flashmessenger()->addInfoMessage($this->getTranslator()->translate('The offer has been edited.'));
                $this->redirect()->toRoute('adminOffer');
            }
        }
        else
        {
            $form->setInputFilter($editOfferFilter->getInputFilter());
            $form->setData($userData = $this->getOfferTable()->getOfferArray($this->params()->fromRoute('id')));
        }
        return new ViewModel(array('form' => $form));
    }
}
