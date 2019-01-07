<?php

namespace App\Model;

class Playlist
{
    /** @var int */
    private $id;

    /** @var string */
    private $title;

    /** @var array */
    private $videos;

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
     * @return Playlist
     */
    public function setId(int $id): Playlist
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Playlist
     */
    public function setTitle(string $title): Playlist
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return array
     */
    public function getVideos(): ?array
    {
        return $this->videos;
    }

    /**
     * @param array $videos
     * @return Playlist
     */
    public function setVideos(array $videos): Playlist
    {
        $this->videos = $videos;

        return $this;
    }

    /**
     * @param Video $video
     * @return Playlist
     */
    public function addVideo(Video $video): Playlist
    {
        $this->videos[] = $video;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasVideos(): bool
    {
        return !empty($this->videos);
    }
}