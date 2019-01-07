<?php

namespace App\Repository\Mysql;

use App\Db\DbConnection;
use App\Model\Playlist;
use App\Model\Video;
use App\Repository\PlaylistRepositoryInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class PlaylistRepository implements PlaylistRepositoryInterface
{
    /** @var \PDO */
    private $pdo;

    /** @var Serializer */
    private $serializer;

    /**
     * VideoRepository constructor.
     */
    public function __construct()
    {
        $this->pdo = DbConnection::getInstance()->getPdo();

        $this->serializer = new Serializer(
            [new ObjectNormalizer(), new ArrayDenormalizer()],
            [new JsonEncoder()]
        );
    }

    /** @inheritdoc */
    public function findOneById(int $id): ?Playlist
    {
        $stmt = $this->pdo->prepare("SELECT * FROM playlist WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        if (false === $data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return null;
        };

        return $this->serializer->deserialize(json_encode($data),
            Playlist::class,
            'json'
        );
    }

    /** @inheritdoc */
    public function findAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM playlist ORDER BY id");
        $stmt->execute();

        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $this->serializer->deserialize(json_encode($data),
            Playlist::class.'[]',
            'json'
        );
    }

    /** @inheritdoc */
    public function insert(array $data): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO playlist (title) VALUES (:title)");
        $stmt->bindValue(':title', $data['title'], \PDO::PARAM_STR);

        return $stmt->execute();
    }

    /** @inheritdoc */
    public function update(int $id, array $data): bool {
        $stmt = $this->pdo->prepare("UPDATE playlist SET title=:title WHERE id=:id");
        $stmt->bindValue(':title', $data['title'], \PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    /** @inheritdoc */
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM playlist WHERE id=:id");
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    /** @inheritdoc */
    public function addVideoToPlaylist(int $id, int $idVideo): bool
    {
        $order = 1;

        $stmt = $this->pdo->prepare("SELECT `order` FROM playlist_video WHERE playlist_id = :playlistId ORDER BY order DESC LIMIT 1");
        $stmt->bindValue(':playlistId', $id, \PDO::PARAM_INT);
        $stmt->execute();

        if ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $order = intval($data['order']) + 1;
        }

        $stmt = $this->pdo->prepare("INSERT INTO playlist_video (`playlist_id`, `video_id`, `order`) VALUES (:playlistId, :videoId, :order)");
        $stmt->bindValue(':playlistId', $id, \PDO::PARAM_INT);
        $stmt->bindValue(':videoId', $idVideo, \PDO::PARAM_INT);
        $stmt->bindValue(':order', $order, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    /** @inheritdoc */
    public function removeVideoFromPlaylist(int $id, int $idVideo): bool
    {
        $order = 0;

        $stmt = $this->pdo->prepare("SELECT `order` FROM playlist_video WHERE playlist_id = :playlistId AND video_id = :videoId");
        $stmt->bindValue(':playlistId', $id, \PDO::PARAM_INT);
        $stmt->bindValue(':videoId', $idVideo, \PDO::PARAM_INT);
        $stmt->execute();

        if ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $order = intval($data['order']);

            $stmt = $this->pdo->prepare("DELETE FROM playlist_video WHERE playlist_id = :playlistId AND video_id = :videoId");
            $stmt->bindValue(':playlistId', $id, \PDO::PARAM_INT);
            $stmt->bindValue(':videoId', $idVideo, \PDO::PARAM_INT);

            if ($stmt->execute()) {
                $stmt = $this->pdo->prepare("UPDATE playlist_video SET `order` = `order` - 1 WHERE playlist_id = :playlistId AND `order` > :order");
                $stmt->bindValue(':playlistId', $id, \PDO::PARAM_INT);
                $stmt->bindValue(':order', $order, \PDO::PARAM_INT);

                return $stmt->execute();
            }

            return false;
        }

        return true;
    }

    /** @inheritdoc */
    public function findVideosFromPlaylistId(int $id): array
    {
        $stmt = $this->pdo->prepare('SELECT video.* FROM playlist_video AS pv LEFT JOIN video ON pv.video_id = video.id WHERE pv.playlist_id = :playlistId ORDER BY pv.order ASC;');
        $stmt->bindValue(':playlistId', $id, \PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $this->serializer->deserialize(json_encode($data),
            Video::class.'[]',
            'json'
        );
    }
}