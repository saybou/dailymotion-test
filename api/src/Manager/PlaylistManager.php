<?php

namespace App\Manager;

use App\Model\Playlist;
use App\Repository\Mysql\PlaylistRepository;
use App\Repository\Mysql\VideoRepository;

class PlaylistManager {

    /** @var PlaylistRepository */
    private $repository;

    /** @var VideoRepository */
    private $videoRepository;

    public function __construct()
    {
        $this->repository = new PlaylistRepository();
        $this->videoRepository = new VideoRepository();
    }

    /**
     * @param int $id
     * @return Playlist
     * @throws \Exception
     */
    public function findOneById(int $id): Playlist
    {
        if (null === $playlist = $this->repository->findOneById($id)) {
            throw new \Exception ('No playlist found for id : "'.$id.'"', 404);
        }

        return $playlist;
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

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->repository->update($id, $data);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * @param int $id
     * @param int $idVideo
     * @return bool
     */
    public function addVideoToPlaylist(int $id, int $idVideo): bool
    {
        if (
            null === $this->repository->findOneById($id)
            || null === $this->videoRepository->findOneById($idVideo)
        ) {
            return false;
        }

        return $this->repository->addVideoToPlaylist($id, $idVideo);
    }

    /**
     * @param int $id
     * @param int $idVideo
     * @return bool
     */
    public function removeVideoFromPlaylist(int $id, int $idVideo): bool
    {
        if (
            null === $this->repository->findOneById($id)
            || null === $this->videoRepository->findOneById($idVideo)
        ) {
            return false;
        }

        return $this->repository->removeVideoFromPlaylist($id, $idVideo);
    }

    /**
     * @param int $id
     * @return array
     * @throws \Exception
     */
    public function findVideosFromPlaylistId(int $id): array
    {
        if (null === $this->repository->findOneById($id)) {
            throw new \Exception ('No playlist found for id : "'.$id.'"', 404);
        }

        return $this->repository->findVideosFromPlaylistId($id);
    }
}