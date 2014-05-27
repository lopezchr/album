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

    	if (empty($oldSheets)) {
			$this->insertSheetsByAlbum($albId,$newSheets);
		}else{

			$arrDiffInsert = array_diff($newSheets, $oldSheets);

			if (!empty($arrDiffInsert)) {		
				$this->insertSheetsByAlbum($albId,$arrDiffInsert);
			}

			$arrDiffDelete = array_diff($oldSheets, $newSheets);

			if (!empty($arrDiffDelete)) {
				$this->deleteSheetsByAlbum($albId,$arrDiffDelete);
			}

		}

    }

    public function insertSheetsByAlbum($albId,$arrSheets)
    {
    	foreach ($arrSheets as $key => $sheet) {
    		$data = array(
    			'alb_id' => $albId,
    			'sht_number' => $sheet
    			);
    		$this->insert($data);
    	}
    }

    public function deleteSheetsByAlbum($albId,$arrSheets)
    {
    	foreach ($arrSheets as $key => $sheet) {
    		$this->delete('alb_id ='.$albId.' AND sht_number ='.$sheet);
    	}
    }
    
}