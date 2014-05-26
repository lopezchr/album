<?php 

/**
* modelo para utilizacion del data table
*/
class Application_Model_DataTable
{
	
	/**
	 * metodo para realizar consulta sobre una tabla usando el datatable
	 * @param  object $request   objeto de request
	 * @param  string $tableName nombre de la tabla de la base de datos
	 * @param  string $tableId   nombre del campo id de la tabla
	 * @param  array $columns   arreglo con columnas de la consulta
	 * @return array            arreglo con resultados y estructura de datos
	 */
	public static function listResult($request,$tableName,$tableId,$columns,$whereparam="",$sqlGroup="")
	{
		$secho = (int) $request->getPost("sEcho");
		
		//paginamos
		$dstar = (int) $request->getPost("iDisplayStart");
		$dlength = (int) $request->getPost("iDisplayLength");

		$sqlLimit = "";
		if (isset($dstar) && ($dlength != -1)) {
		    $sqlLimit  = " LIMIT $dstar, $dlength ";
		}
                
                

		//obtenemos listado
		$db = Zend_Db_Table::getDefaultAdapter();
		$sqltotal = "SELECT COUNT({$tableId}) as conteo FROM {$tableName}";
		
                $resultotalb = $db->fetchAll($sqltotal);
                 
		$totalCount = $resultotalb[0]["conteo"];
                
                //filtramos
		$search = trim($request->getPost("sSearch",""));
		$sqlWhere = "";
		if (!empty($search)) {

		    $sqlWhere = " WHERE (";
		    for ($i = 0 ; $i < count($columns); $i++){

		    	$pos = strpos($whereparam ,$columns[$i]);

		    	if ($pos === false) {

			        $searcheable = $request->getPost("bSearchable_".$i);
			        if ($searcheable == 'true') {
			            $sqlWhere.= $columns[$i]." LIKE '%{$search}%' OR ";
			        }
		    	}

		    }
		    $sqlWhere = substr_replace( $sqlWhere, "", -3 );
		    $sqlWhere .= ") ";
		}

		if(!empty($sqlWhere)){

			if (!empty($whereparam) && is_string($whereparam)) {
				$sqlWhere .= " AND ({$whereparam}) ";
			}
			
		}elseif($whereparam != '' && is_string($whereparam)){
			$sqlWhere .= " WHERE ({$whereparam}) ";
		}

		//ordenamos
		$isortCols = (int) $request->getPost("iSortingCols");
		$sqlOrder = "";
		if ($isortCols > 0) {
		    $sqlOrder = " ORDER BY ";

		    for ($i=0 ; $i<$isortCols ; $i++){

		        $isortColumn = $request->getPost("iSortCol_".$i);
		        $sortColumn = $request->getPost("bSortable_".$isortColumn);
		        $isortDir = $request->getPost("sSortDir_".$i);

		        if ($sortColumn == 'true') {

		        	$sqlOrder .= $columns[$isortColumn].", ";
		        }

		    }

		    $sqlOrder = substr_replace($sqlOrder, "",-2);
		    $sqlOrder .= " ".strtoupper($isortDir);
		}

		$sqlColumns = "";
		foreach ($columns as $key => $value) {
			$sqlColumns .= "{$value}, ";
		}
		$sqlColumns = substr_replace($sqlColumns, "",-2);

		if($sqlGroup != ''){
			$sqlGroup = 'GROUP BY '.$sqlGroup;
			$sqlOrder ='';
		}

		$sql = "SELECT SQL_CALC_FOUND_ROWS
		{$sqlColumns}
		FROM {$tableName}
		{$sqlWhere}
		{$sqlOrder}
		{$sqlGroup}
		{$sqlLimit}
		";
		
                //return $sql;
		//die();
		
		$result =  $db->fetchAll($sql);

		//consultamos resultados encontrados
		$sqltotal = "SELECT FOUND_ROWS() as conteo";
		$resultotalb = $db->fetchAll($sqltotal);
		$totalCountFiltered = $resultotalb[0]["conteo"];

		//arreglo con datos filtrados par convertir en json
		$output = array(
		        "sEcho" => $secho,
		        "iTotalRecords" => $totalCount,
		        "iTotalDisplayRecords" => $totalCountFiltered,
		        "aaData" => array()
		);

		return array("output"=>$output,"result"=>$result);
	}
}