<?php

class Cat_Mod extends Model{
	static public $data    = array();
	protected $table       = "source";
	protected $result      = array();
	protected $fatchedRows = 0;
	/**
	 * Class Constructor
	 */
	public function __construct()
	{

	}

	public function __destruct(){
		self::$data = array();
	}

	static public function getCat(){
		$catName = "index";
		if (count($_GET) > 0) {
			self::$data = $_GET;
			if (array_key_exists('cat', array_filter(self::$data))) {
				return self::$data['cat'];
			}
		}
		return $catName;
	}

	public function getSource($id){
		$sql = " cat.name, source.catId, source.name, source.eName, source.addTime, source.picBigLink, source.sourceLink, source.scope, source.size FROM cat INNER JOIN source ON source.catId = cat.$id";
		$sql = "select". $sql;
		return $this->result = $this->get_all($sql);
}
}
