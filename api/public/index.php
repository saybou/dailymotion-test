<?php

require_once __DIR__.'/../vendor/autoload.php';

$type = $_GET['type'] ?? null;
$id = $_GET['id'] ?? null;

$controllerName = 'App\Controller\\'.rtrim(ucwords($type), 's').'Controller';
$controller = new $controllerName();

switch ($_SERVER["REQUEST_METHOD"]) {
	case 'GET':
		if($id) {
			$controller->getContentAction($id);
		} else {
			$controller->getAllContentsAction();
		}
		break;
	case 'POST':
		$json = json_decode(file_get_contents("php://input"),true);
		$controller->insertContentAction($json['data']);
		break;
	case 'PATCH':
		if($id) {
			$json = json_decode(file_get_contents("php://input"), true);
			$controller->updateContentAction($id, $json['data']);
		}
		break;
	case 'DELETE' :
		if($id) {
			$controller->deleteContentAction($id);
		}
		break;
	default:
		header("HTTP/1.0 405 Method Not Allowed");
		break;
}

?>

