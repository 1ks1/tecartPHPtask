<?PHP 

namespace libs;

class Router 
{
	public $uris = [];
	public $params = [];
	public $action = '';
	public $controller;
	public $viewer;
	
	function __construct()
	{
		$this->controller = new \libs\Controller;
		$this->viewer = new \libs\Viewer;
		
		foreach($_GET as $key => $val) {
			if ($key == 'route') {
				$this->uris = explode('/', $val);
			} else {
				$this->params[$key] = $val;
			}
		}
		
		$this->getAction();
		$this->run();
	}
	
	function getAction() {
		$action = array_shift($this->uris);
		$this->action = false;
		include_once('RouteList.php');
		foreach ($routelist as $k => $v) {
			if ($action == $k) {
				$this->action = $v;
			}
		}
	}
	
	function run()
	{
		$result = null;
		$controller = $this->controller;
		
		if (strlen($this->action) > 0) {
			if (method_exists($controller, $this->action)) {
				$result = call_user_func_array([$controller, $this->action], $this->params);
			} else {
				$result =  call_user_func_array([$controller, 'error'], ['404']);
			}
		} else {
			$result = call_user_func_array([$controller, 'error'], ['404']);
		}
		
		echo $result;
	}
	
}