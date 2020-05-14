<?PHP 

namespace libs;

class Model
{
	public $db;
	
	function __construct()
	{
		$this->db = new Db;
	}
	
	function newsList($page = 1)
	{
		$onceOnPage = ONCEPAGE;
		if (is_numeric($page))
		$sql = "select * from news ORDER BY idate DESC, id DESC limit ". ($page*$onceOnPage) .", $onceOnPage";
		$result = $this->db->query($sql);
		$res['dbresult'] = $result->fetchAll();
		$res['allPages'] = $this->allPages($onceOnPage);
		$res['onceOnPage'] = $onceOnPage;
		return $res;
	}
	
	function oneNew($id = 1)
	{
		if (is_numeric($id))
		$sql = "select * from news where id=" . $id;
		$res = $this->db->query($sql);
		$res = $res->fetchAll();
		return $res;
	}
	
	function allPages()
	{
		$once = ONCEPAGE;
		$sql = "select count(id) from news";
		$res = $this->db->query($sql);
		$res = $res->fetchAll()[0]['count(id)'];
		$records = $res;
		$res = ceil($res/$once);
		$pages = $res - 1;
		return ['pages' => $pages, 'records' => $records];
	}
	
	function checkPageNumber($pageSelected)
	{
		$pagesData = $this->allPages();
		$res = 1;
		if (!empty($pageSelected) && is_numeric($pageSelected))
			$res = $pageSelected;
		if ($pageSelected > $pagesData['pages'])
			$res = $pagesData['pages'];
		if ($pageSelected < 1)
			$res = 1;
		return $res;
	}

}