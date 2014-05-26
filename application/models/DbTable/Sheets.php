<?php 

class Application_Model_DbTable_Sheets extends Zend_Db_Table_Abstract
{

    //Atributos de la clase
    protected $_name = 'sheets';
    protected $_primary = 'sht_id';

    public function getSheetsByAlbum($albId)
    {
    	$rows = $this->fetchAll("alb_id=".$albId)->toArray();
    	$result = array();

    	if(!empty($rows)){
    		foreach ($rows as $key => $sheet) {
    			$result[] = $sheet['sht_number'];
    		}	
    	}
    	
    	return $result;
    }

    public function updateSheetsByAlbum($albId,$newSheets)
    {
    	$oldSheets = $this->getSheetsByAlbum($albId);

    	$arrAdd = array_diff($newSheets, $oldSheets);

    }
    
}