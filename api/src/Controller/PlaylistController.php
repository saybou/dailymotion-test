<?php

namespace App\Controller;

use App\Manager\PlaylistManager;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class PlaylistController {

    /** @var PlaylistManager */
    private $manager;

    private $serializer;

    public function __construct() {
	    $this->manager = new PlaylistManager();
        $this->serializer = new Serializer(
            [new ObjectNormalizer()],
            [new JsonEncoder()]
        );
    }

	public function getContentAction(int $id)
	{
        header('Content-Type: application/json');

	    try {
            $video = $this->manager->findOneById($id);
        } catch (\Exception $e) {
            http_response_code($e->getCode());
            echo $this->serializer->serialize(
                [
                    'error' => [
                        'code' => $e->getCode(),
                        'message' => $e->getMessage()
                    ]
                ],
            'json'
            );
            exit();
        }

        http_response_code(200);
        echo $this->serializer->serialize(
            ['data' => $video],
            'json'
        );
	}

    public function getAllContentsAction()
    {
        header('Content-Type: application/json');

        $videos = $this->manager->findAll();

        http_response_code(200);
        echo $this->serializer->serialize(
            ['data' => $videos],
            'json'
        );
    }

    public function insertContentAction(array $data)
    {
        header('Content-Type: application/json');

        if($this->manager->insert($data)) {
            http_response_code(201);
            $code = 201;
            $message = 'Playlist created successfully.';
        } else {
            http_response_code(422);
            $code = 422;
            $message = 'Playlist creation failed.';
        }

        echo $this->serializer->serialize(
            [
                'code' => $code,
                'message' => $message
            ],
            'json'
        );
    }

    public function updateContentAction(int $id, array $data)
    {
        header('Content-Type: application/json');

        if($this->manager->update($id, $data)) {
            http_response_code(200);
            $code = 200;
            $message = 'Playlist updated successfully.';
        } else {
            http_response_code(422);
            $code = 422;
            $message = 'Playlist update failed.';
        }

        echo $this->serializer->serialize(
            [
                'code' => $code,
                'message' => $message
            ],
            'json'
        );
    }

    public function deleteContentAction(int $id)
    {
        header('Content-Type: application/json');

        if($this->manager->delete($id)) {
            http_response_code(200);
            $code = 200;
            $message = 'Playlist removed successfully.';
        } else {
            http_response_code(422);
            $code = 422;
            $message = 'Playlist removing failed.';
        }

        echo $this->serializer->serialize(
            [
                'code' => $code,
                'message' => $message
            ],
            'json'
        );
    }

    public function addVideoToPlaylistAction(int $id, int $idVideo)
    {
        header('Content-Type: application/json');

        if($this->manager->addVideoToPlaylist($id, $idVideo)) {
            http_response_code(200);
            $code = 200;
            $message = 'Video added to playlist successfully.';
        } else {
            http_response_code(422);
            $code = 422;
            $message = 'Video add to playlist failed.';
        }

        echo $this->serializer->serialize(
            [
                'code' => $code,
                'message' => $message
            ],
            'json'
        );
    }

    public function removeVideoFromPlaylistAction(int $id, int $idVideo)
    {
        header('Content-Type: application/json');

        if($this->manager->removeVideoFromPlaylist($id, $idVideo)) {
            http_response_code(200);
            $code = 200;
            $message = 'Video removed from playlist successfully.';
        } else {
            http_response_code(422);
            $code = 422;
            $message = 'Video removing from playlist failed.';
        }

        echo $this->serializer->serialize(
            [
                'code' => $code,
                'message' => $message
            ],
            'json'
        );
    }

    public function getVideosFromPlaylistAction(int $id)
    {
        header('Content-Type: application/json');

        try {
            $videos = $this->manager->findVideosFromPlaylistId($id);
        } catch (\Exception $e) {
            http_response_code($e->getCode());
            echo $this->serializer->serialize(
                [
                    'error' => [
                        'code' => $e->getCode(),
                        'message' => $e->getMessage()
                    ]
                ],
                'json'
            );
            exit();
        }

        http_response_code(200);
        echo $this->serializer->serialize(
            ['data' => $videos],
            'json'
        );
    }
}