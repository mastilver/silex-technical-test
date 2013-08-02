<?php

class NewsService
{
	private $db;
	
	public function __construct($db)
	{
		$this->db = $db;
	}
	
	public function get_latest()
	{
		$sql = '	SELECT * FROM news
					WHERE id <= 10
					ORDER BY id asc';
		
		return $this->db->query($sql);
	}
	
	public function get_id($id)
	{
		$sql = '	SELECT * FROM news
					WHERE id = :id';
		
		$query = $this->db->prepare($sql);
		$query->bindValue('id', $id);
		
		$query->execute();
		return $query->fetch();
	}
}

?>
