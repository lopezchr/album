<?php 

class Application_Model_DbTable_Sections extends Zend_Db_Table_Abstract
{

    //Atributos de la clase
    protected $_name = 'album_sections';
    protected $_primary = 'als_id';

    /*
    * METODO PARA CREAR UNA SECCION POR DEFECTO AL ALBUM
    */
    public function createDefaultSection($albId)
    {
    	try {
    		$data = array(
	    		'alb_id' 			=> $albId,
	    		'als_name'			=> 'Default Sectction',
	    		'als_order' 		=> 1,
	    		'als_num_sheets' 	=> 300
	    		);

	    	$id = $this->insert($data);
    	return $id;
    		
    	} catch (Exception $e) {
    		throw $e;
    	}
    }
    
}