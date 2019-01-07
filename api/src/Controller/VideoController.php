<?php

namespace App\Controller;

use App\Manager\VideoManager;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class VideoController {

    /** @var VideoManager */
    private $manager;

    private $serializer;

    public function __construct() {
	    $this->manager = new VideoManager();
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
            $message = 'Video created successfully.';
        } else {
            http_response_code(422);
            $code = 422;
            $message = 'Video creation failed.';
        }

        echo $this->serializer->serialize(
            [
                'code' => $code,
                'message' => $message
            ],
            'json'
        );
    }

    public function updateContentAction(array $data)
    {
        header('Content-Type: application/json');
        http_response_code(501);

        echo $this->serializer->serialize(
            [
                'code' => 501,
                'message' => 'Not implemented.'
            ],
            'json'
        );
    }

    public function deleteContentAction(array $data)
    {
        header('Content-Type: application/json');
        http_response_code(501);

        echo $this->serializer->serialize(
            [
                'code' => 501,
                'message' => 'Not implemented.'
            ],
            'json'
        );
    }
}