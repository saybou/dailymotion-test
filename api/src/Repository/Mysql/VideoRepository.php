<?php

namespace App\Repository\Mysql;

use App\Db\DbConnection;
use App\Model\Video;
use App\Repository\VideoRepositoryInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class VideoRepository implements VideoRepositoryInterface
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
    public function findOneById(int $id): ?Video
    {
        $stmt = $this->pdo->prepare("SELECT * FROM video WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        if (false === $data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return null;
        };

        return $this->serializer->deserialize(json_encode($data),
            Video::class,
            'json'
        );
    }

    /** @inheritdoc */
    public function findAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM video ORDER BY id");
        $stmt->execute();

        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $this->serializer->deserialize(json_encode($data),
            Video::class.'[]',
            'json'
        );
    }

    /** @inheritdoc */
    public function insert(array $data): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO video (name, thumbnail) VALUES (:name, :thumbnail)");
        $stmt->bindValue(':name', $data['name'], \PDO::PARAM_STR);
        $stmt->bindValue(':thumbnail', $data['thumbnail'] ?? '', \PDO::PARAM_STR);

        return $stmt->execute();
    }
}