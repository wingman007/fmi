<?php
// ini_set('display_errors', '1');
// chdir(dirname(__DIR__)); // change to the root of the project
/**
 * The script allows you to access assets outsite of "public" folder
 * 
 * example with this file
 * <img src="http://localhost:10122/loader.php?file=1_phpdocumentor.png" />
 * example with file manager module. Only members can access
 * <img src="http://localhost:10122/csn-file-manager/index/get-image/121012_EB.JPG" />
 */
// 1) set the folder with the assets
$path = realpath(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . '54' ;
// get the file (e.g. http://localhost:10122/loader.php?file=css\style.css) or css/style.css
$file = $_GET['file'];
// 3) create the path
$filename = $path . DIRECTORY_SEPARATOR . $file;
// 4) determen the MIME file type
$extension = array_pop(explode('.', $file));
switch ($extension) {
	case 'css' :
		$mime = 'text/css';
		break;
	case 'js' :
		$mime = 'text/javascript';
		break;
	case 'jpg' :
	case 'jpeg':
	case 'JPG' :
	case 'JPEG':
		$mime = 'image/jpeg';
		break;
	case 'png' :
		$mime = 'image/png';
		break;
	case 'gif' :
		$mime = 'image/gif';
		break;
	default:
		$mime = 'text/text';
		break;
}

if (file_exists($filename)) {
	header('Content-Type: ' . $mime);
	ob_clean();
	flush();
	readfile($filename);
	exit;	
}

header("HTTP/1.0 404 Not Found");