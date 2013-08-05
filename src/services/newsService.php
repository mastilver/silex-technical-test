<?php

class NewsService
{
	private $db;
	private $formFactory;
	
	public function __construct($db/*, $formFactory*/)
	{
		$this->db = $db;
		//$this->formFactory = $formFactory;
	}
	
	public function get_latest()
	{
		$queryBuilder = $this->db->createQueryBuilder();
		
		$queryBuilder->select('*')
					->from('news')
					->orderBy('news.id', 'DESC')
					->setFirstResult(0)
					->setMaxResults(10);
		
		
		
		
		
		return $this->db->fetchAll($queryBuilder->getSQL());
		
		//return $query->getArrayResult();
		
		
		
		
		/*$sql = '	SELECT * FROM news
					WHERE id <= 10
					ORDER BY id desc';
		
		return $this->db->query($sql);*/
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
	
	public function add_news($formContent)
	{
		$sqlMaxId = 'SELECT max(id) as maxid FROM news';
		
		$formContent['id'] = $this->db->query($sqlMaxId)->fetch()['maxid'] + 1;
		
		$this->db->insert('news', $formContent);
	}
	
	public function get_add_news_form()
	{
		return $this->formFactory->createBuilder('form')
					->setAction('/web/index.php/addnews')
					->add('title', 'text')
					->add('short description', 'text')
					->add('news', 'text')
					->add('post this news', 'submit')
					->getForm();
	}
}

?>
