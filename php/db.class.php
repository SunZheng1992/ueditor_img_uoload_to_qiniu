<?php

class db
{
	public $db;

	public function __construct()
	{
		$config = include('config.php');
		$this->db =new mysqli($config['dbhost'], $config['dbuser'],$config['dbpwd']);
		
		if(mysqli_connect_errno())
		{
			$this->writeLog("连接失败".mysqli_connect_error());
		}
		if(!$this->db->select_db($config['dbname']))
		{
			$this->writeLog('数据库选择失败');
			return false;
		};
	}
	
	public function query($sql)
	{
		return	$this->db->query($sql);
	}
	private function writeLog($content)
	{

		file_put_contents('ueditor.log',date('Y-m-d H:i:s').':'.$content."\r\n",FILE_APPEND); 
	
	}
}	