<?php

namespace App\Repository;

use App\Model\Video;

interface VideoRepositoryInterface
{
    /**
     * @param int $id
     * @return Video
     */
    public function findOneById(int $id): ?Video;

    /**
     * @return array
     */
    public function findAll(): array;

    /**
     * @param array $data
     * @return bool
     */
    public function insert(array $data): bool;
}