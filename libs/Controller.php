<?PHP

namespace libs;

class Controller
{
	public $viewer;
	public $model;
	
	function __construct()
	{
		$this->viewer = new \libs\Viewer;
		$this->model = new \libs\Model;
	}
	
	function news()
	{	
		$pageSelected = 1;
		if (!empty($_GET['page']))
			$pageSelected = $_GET['page'];
		$pageSelected = $this->model->checkPageNumber($pageSelected);
		$res = $this->model->newsList($pageSelected);
		$data = $res;
		$data['page'] = $pageSelected;
		$data['newsBlockHtml'] = $this->viewer->newsBlockHtml($data);
		$data['buttonsBlockHtml'] = $this->viewer->buttonsBlockHtml($data);
		$this->viewer->render('news', $data);
	}
	
	function oneNew($id = 1)
	{
		$res = $this->model->oneNew($id);
		$data = $res;
		$this->viewer->render('new', $data);
	}
	
	function css($filename = 'main.css')
	{
		$this->viewer->css($filename);
	}
	
	function error($type='404')
	{
		header("HTTP/1.0 404 Not Found");
		return 'Error 404';
	}
}