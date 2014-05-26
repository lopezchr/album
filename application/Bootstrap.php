<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	private static $_db;

	protected function _initDbAdapter()
	{
		date_default_timezone_set("America/Bogota");
		$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini', 'development');
		
		$db = Zend_Db::factory('PDO_MYSQL', array(
		   'host'     => $config->resources->db->params->host,
		   'username' => $config->resources->db->params->username,
		   'password' => $config->resources->db->params->password,
		   'dbname'   => $config->resources->db->params->dbname
		));

		self::$_db = $db;
		Zend_Db_Table_Abstract::setDefaultAdapter(self::$_db);
		
	}
}

