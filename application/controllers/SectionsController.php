<?php

class SectionsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $id = $this->_request->getParam('id','');
        $this->view->id = $id;
    }

    /*
    *  METODO PARA LISTAR LAS SECCIONES POR ALBUM
    */
    public function listSectionsAction()
    {   
        $id = $this->_request->getParam('id','');

        //definimos la columnas sobre las cuales se puede filtrar, buscar y consultar
        $columns = array(
                "als_name",
                "als_order",
                "als_num_sheets",
                "als_id"
        );

        $where = " alb_id =".$id;

        //obtenemos resultados de la consulta
        $result = Application_Model_DataTable::listResult($this->_request,'album_sections','als_id',$columns,$where);
        
        //procesamos resultados
        foreach ($result['result']as $register) {
        	$optionsView = new Zend_View();
			$optionsView->addScriptPath(VIEWS_PATH.'/sections');
			$optionsView->id = $register['als_id'];
			$optionsHTML = $optionsView->render('options.phtml');

            //agregamos resultados al arreglo de resultados
            $result['output']['aaData'][] = array(
                        $register['als_name'],
                        $register['als_order'],
                        $register['als_num_sheets'],
                        $optionsHTML
                    );
        }
        //enviamos resultados de respuesta en json
        $this->getResponse()->appendBody($this->_helper->json($result['output']));
    }

    /*
    *	METODO PARA REGISTRAR O ACTUALIZAR UNA SECCION DE UN ALBUM
    */
    public function modifySectionAction()
    {
    	try {
            $id = $this->_request->getParam('id','');

			$data = array(
                "alb_id" => $this->_request->getParam('albId'),
				"als_name" => $this->_request->getParam('name'),
				"als_order" => $this->_request->getParam('order'),
				"als_num_sheets" => $this->_request->getParam('num_sheets')
				);

			$model = new Application_Model_DbTable_Sections();

			//Edicion de album
			if($id != ''){
				$model->update($data,'als_id ='.$id);
			}else{
				$id = $model->insert($data);
			}

			$output = array('success'=>true,'description'=>$id);
			$this->getResponse()->appendBody($this->_helper->json($output));

		} catch (Exception $e) {
			$output = array('success'=>false,'description'=>$e->getMessage());
			$this->getResponse()->appendBody($this->_helper->json($output));
		}
    }

    /*
    *	METODO PARA ELIMINAR UNA SECCION DE UN ALBUM
    */
    public function deleteSectionAction()
    {
    	try {
    		$id = $this->_request->getParam('id','');
    		$model = new Application_Model_DbTable_Sections();

    		$model->delete("als_id=".$id);

    		$output = array('success'=>true,'description'=>"deleted");
			$this->getResponse()->appendBody($this->_helper->json($output));
    		
    	} catch (Exception $e) {
    		$output = array('success'=>false,'description'=>$e->getMessage());
			$this->getResponse()->appendBody($this->_helper->json($output));
    	}
    }

    /*
    *	METODO PARA OBTENER INFORMACION BASICA DE UNA SECCION
    */
    public function getSectionBasicInfoAction()
    {
    	try {
    		$id = $this->_request->getParam('id','');
    		$model = new Application_Model_DbTable_Sections();
    		$album = $model->fetchRow('als_id ='.$id)->toArray();

    		$output = array('success'=>true,'description'=>$album);
			$this->getResponse()->appendBody($this->_helper->json($output));
    	} catch (Exception $e) {
    		$output = array('success'=>false,'description'=>$e->getMessage());
			$this->getResponse()->appendBody($this->_helper->json($output));
    	}
    }


}

