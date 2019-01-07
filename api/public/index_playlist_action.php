<?php

require_once __DIR__.'/../vendor/autoload.php';

$id = $_GET['id'] ?? null;
$idVideo = $_GET['idvideo'] ?? null;
$action = $_GET['action'] ?? null;

$controller = new \App\Controller\PlaylistController();

switch ($action) {
    case 'addorremoveplaylistvideo':
        if ('POST' === $_SERVER["REQUEST_METHOD"]) {
            $controller->addVideoToPlaylistAction($id, $idVideo);
        } elseif ('DELETE' === $_SERVER["REQUEST_METHOD"]) {
            $controller->removeVideoFromPlaylistAction($id, $idVideo);
        }
    break;
    case 'listplaylistvideo':
        if ('GET' === $_SERVER["REQUEST_METHOD"]) {
            $controller->getVideosFromPlaylistAction($id);
        }
    break;
}

?>

