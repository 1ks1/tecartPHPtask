<?PHP
spl_autoload_register(function($className) {
	$filename = str_replace('\\', '/', $className) . '.php';
	if (file_exists($filename))
		include_once $filename;
});