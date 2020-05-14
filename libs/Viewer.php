<?PHP

namespace libs;

class Viewer
{
	function render($templateName = 'news', $data = [])
	{
		include ROOT . "/templates/header.php";
		include ROOT . "/templates/$templateName.php";
		include ROOT . "/templates/footer.php";
	}
	
	function css($cssFile = 'main.css')
	{
		$f = ROOT . '/css/' . $cssFile;
		$res = file_get_contents($f);
		header("Content-type: text/css");
		echo $res;
	}

	function newsBlockHtml($data)
	{
		$res = '';
		$block = '';
		date_default_timezone_set('UTC');
		foreach ($data['dbresult'] as $key => $post) {
			if (is_numeric($key)) {
				$date = date("d.m.Y", $post['idate']);
				$link = '<a href="view?id=' . $post['id'] . '">' . $post['title'] . '</a>';
				$date =  '<span class="date">' . $date . '</span>';
				$announce = '<p>' . $post['announce'] . '</p>';
				$block = "$date $link <br />$announce";
			}
			$res .= $block;
		}
		return $res;
	}
	
	function buttonsBlockHtml($data)
	{
		$res = '';
		for ($i = 1; $i < $data['allPages']['pages']+1; $i++) {
			$btn = '<a class="page_link" href="news?page=' . $i . '">' . $i . '</a>';	
			if ($data['page'] == $i)
				$btn = '<span class="current page_link">' . $i . '</span>';
			$res .= $btn;
		}
		return $res;
	}
	
}