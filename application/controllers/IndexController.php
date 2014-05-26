<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function listAlbumsAction()
    {   
        //definimos la columnas sobre las cuales se puede filtrar, buscar y consultar
        $columns = array(
                "alb_id",
                "alb_name",
                "alb_description",
                "alb_year"
        );

        //obtenemos resultados de la consulta
        $result = Application_Model_DataTable::listResult($this->_request,'albums','alb_id',$columns);
        
        //procesamos resultados
        foreach ($result['result']as $register) {
        	$optionsView = new Zend_View();
			$optionsView->addScriptPath(VIEWS_PATH.'/index');
			$optionsView->id = $register['alb_id'];
			$optionsHTML = $optionsView->render('options.phtml');

            //agregamos resultados al arreglo de resultados
            $result['output']['aaData'][] = array(
                        $register['alb_id'],
                        $register['alb_name'],
                        $register['alb_description'],
                        $register['alb_year'],
                        $optionsHTML
                    );
        }
        //enviamos resultados de respuesta en json
        $this->getResponse()->appendBody($this->_helper->json($result['output']));
    }

    /*
    *	METODO PARA REGISTRAR O ACTUALIZAR UN ALBUM
    */
    public function modifyAlbumAction()
    {
    	try {
			$id = $this->_request->getParam('id','');

			$data = array(
				"alb_name" => $this->_request->getParam('name'),
				"alb_description" => $this->_request->getParam('description'),
				"alb_year" => $this->_request->getParam('year')
				);

			$model = new Application_Model_DbTable_Albums();

			//Edicion de album
			if($id != ''){
				$model->update($data,'alb_id ='.$id);
			}else{
				$id = $model->insert($data);

                $alsModel = new Application_Model_DbTable_Sections();
                $alsModel->createDefaultSection($id);
			}

			$output = array('success'=>true,'description'=>$id);
			$this->getResponse()->appendBody($this->_helper->json($output));

		} catch (Exception $e) {
			$output = array('success'=>false,'description'=>$e->getMessage());
			$this->getResponse()->appendBody($this->_helper->json($output));
		}
    }

    /*
    *	METODO PARA ELIMINAR UN ALBUM
    */
    public function deleteAlbumAction()
    {
    	try {
    		$id = $this->_request->getParam('id','');
    		$model = new Application_Model_DbTable_Albums();

    		$model->delete("alb_id=".$id);

    		$output = array('success'=>true,'description'=>"deleted");
			$this->getResponse()->appendBody($this->_helper->json($output));
    		
    	} catch (Exception $e) {
    		$output = array('success'=>false,'description'=>$e->getMessage());
			$this->getResponse()->appendBody($this->_helper->json($output));
    	}
    }

    /*
    *	METODO PARA OBTENER INFORMACION BASICA DE UN ALBUM
    */
    public function getAlbumBasicInfoAction()
    {
    	try {
    		$id = $this->_request->getParam('id','');
    		$model = new Application_Model_DbTable_Albums();
    		$album = $model->fetchRow('alb_id ='.$id)->toArray();

    		$output = array('success'=>true,'description'=>$album);
			$this->getResponse()->appendBody($this->_helper->json($output));
    	} catch (Exception $e) {
    		$output = array('success'=>false,'description'=>$e->getMessage());
			$this->getResponse()->appendBody($this->_helper->json($output));
    	}
    }


}

