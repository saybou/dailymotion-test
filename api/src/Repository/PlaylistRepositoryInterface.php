<?php

namespace App\Repository;

use App\Model\Playlist;

interface PlaylistRepositoryInterface
{
    /**
     * @param int $id
     * @return Playlist
     */
    public function findOneById(int $id): ?Playlist;

    /**
     * @return array
     */
    public function findAll(): array;

    /**
     * @param array $data
     * @return bool
     */
    public function insert(array $data): bool;

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * @param int $id
     * @param int $idVideo
     * @return bool
     */
    public function addVideoToPlaylist(int $id, int $idVideo): bool;

    /**
     * @param int $id
     * @param int $idVideo
     * @return bool
     */
    public function removeVideoFromPlaylist(int $id, int $idVideo): bool;

    /**
     * @param int $id
     * @return array
     */
    public function findVideosFromPlaylistId(int $id): array;
}