<?php

namespace App\Model;

class Video
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $thumbnail;

    // -------------------------------------------------------------------------

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Video
     */
    public function setId(int $id): Video
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Video
     */
    public function setName(string $name): Video
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    /**
     * @param string $thumbnail
     * @return Video
     */
    public function setThumbnail(string $thumbnail): Video
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }
}