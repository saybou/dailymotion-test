<?php

namespace App\Manager;

use App\Model\Video;
use App\Repository\Mysql\VideoRepository;

class VideoManager {

    /** @var VideoRepository */
    private $repository;

    public function __construct()
    {
        $this->repository = new VideoRepository();
    }

    /**
     * @param int $id
     * @return Video
     * @throws \Exception
     */
    public function findOneById(int $id): Video
    {
        if (null === $video = $this->repository->findOneById($id)) {
            throw new \Exception ('No video found for id : "'.$id.'"', 404);
        }

        return $video;
    }

    /**
     * @return array
     */
    public function findAll(): array {
        return $this->repository->findAll();
    }

    /**
     * @param array $data
     * @return bool
     */
    public function insert(array $data): bool
    {
        return $this->repository->insert($data);
    }
}