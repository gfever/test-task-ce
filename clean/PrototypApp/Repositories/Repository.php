<?php
/**
 * @author d.ivaschenko
 */

namespace PrototypApp\Repositories;


use PrototypApp\Container;
use PrototypApp\Models\ModelInterface;

/**
 * Class Repository
 * @package PrototypApp\Repositories
 */
abstract class Repository implements RepositoryInterface
{
    protected $table;
    protected $connection;
    protected $model;

    protected $where;

    public function __construct()
    {
        if (Container::isInstanced(\PDO::class)) {
            $this->connection = Container::make(\PDO::class);
        } else {
            $config = include __DIR__ . '/../../config/database.php';
            $this->connection = new \PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['username'], $config['password']);
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param string $type
     * @param array $data
     * @return ModelInterface
     * @throws \ErrorException
     */
    public function createNew(string $type, array $data): ModelInterface
    {
        $modelClassName = '\App\Models\\' . ucfirst($type);
        /** @var ModelInterface $newModel */
        $newModel = new $modelClassName();
        $newModel->fill($data);

        $this->create($newModel);

        return $newModel;
    }

    /**
     * @param ModelInterface $model
     * @return bool
     * @throws \ErrorException
     */
    public function create(ModelInterface $model): bool
    {
        $attributes = array_filter($model->getAttributes());

        $keys = array_map(function ($value) {
            return ':' . $value;
        }, array_keys($attributes));

        $sql = 'INSERT INTO ' . $this->table . ' (' . implode(',', array_keys($attributes)) . ') VALUES (' . implode(',', $keys) . ')';
        $this->getConnection()->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
        $query = $this->getConnection()->prepare($sql);

        $result = $query->execute(array_combine($keys, array_values($attributes)));
        if (!$result) {
            throw new \ErrorException($this->getConnection()->errorInfo());
        }
        $model->id = $this->getConnection()->lastInsertId();
        return $result;
    }


    /**
     * @param ModelInterface $model
     * @param string $status
     * @return bool
     * @throws \ErrorException
     */
    public function updateStatus(ModelInterface $model, string $status): bool
    {
        $sql = 'UPDATE ' . $this->table . ' SET status = :status WHERE id = :id';
        $this->getConnection()->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
        $query = $this->getConnection()->prepare($sql);

        $result = $query->execute(['status' => $status, 'id' => $model->id]);
        if (!$result) {
            throw new \ErrorException($this->getConnection()->errorInfo());
        }

        $model->status = $status;
        return $result;
    }

    /**
     * @param string $name
     * @param string $value
     * @return mixed
     */
    public function getOneBy(string $name, string $value)
    {
        $query = "SELECT * FROM {$this->table} WHERE {$name} = :val LIMIT 1";
        $statement = $this->getConnection()->prepare($query);
        $statement->bindValue(':val', $value, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS, $this->model);
        $statement->execute();

        return $statement->fetch();
    }

    /**
     * @param string $type
     * @return RepositoryInterface
     */
    public static function getRepositoryByType(string $type): RepositoryInterface
    {
        return Container::make('\App\Repositories\\' . ucfirst($type) . 'Repository');
    }


}