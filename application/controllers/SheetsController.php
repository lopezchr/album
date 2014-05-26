<?php

class SheetsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $id = $this->_request->getParam('id','');

        $absModel = new Application_Model_DbTable_Sections();
        $sheModel = new Application_Model_DbTable_Sheets();
        $albModel = new Application_Model_DbTable_Albums();

        $sections = $absModel->fetchAll('alb_id='.$id)->toArray();
        $sheets = $sheModel->getSheetsByAlbum($id);
        $album = $albModel->fetchRow('alb_id='.$id)->toArray();

        $this->view->sections = $sections;
        $this->view->sheets = $sheets;
        $this->view->album = $album;

    }

    public function saveSheetsAction(){
        try {
            $id = $this->_request->getParam('id','');
            $newSheets = $this->_request->getParam('sheets');

            $sheModel = new Application_Model_DbTable_Sheets();

            $sheModel->updateSheetsByAlbum($id,$newSheets);

            $output = array('success'=>true,'description'=>$id);
            $this->getResponse()->appendBody($this->_helper->json($output));

        } catch (Exception $e) {
            $output = array('success'=>false,'description'=>$e->getMessage());
            $this->getResponse()->appendBody($this->_helper->json($output));
        }
    }

}

