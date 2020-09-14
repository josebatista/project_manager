<?php


namespace JBP\Framework;

use Pimple\Container;

abstract class Model
{
    protected $db;
    protected $events;
    protected $queryBuilder;
    protected $table;

    public function __construct(Container $container)
    {
        $this->db = $container['db'];
        $this->events = $container['events'];
        $this->queryBuilder = new QueryBuilder();

        if (!$this->table) {
            $table = explode('\\', get_called_class());
            $table = array_pop($table);
            $this->table = strtolower($table);
        }
    }

    public function get(array $conditions)
    {
        try {
            $query = $this->queryBuilder->select($this->table)->where($conditions)->getData();

            $stmt = $this->db->prepare($query->sql);
            $stmt->execute($query->bind);

            return $stmt->fetch(\PDO::FETCH_ASSOC);

        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return null;
    }

    public function all(array $conditions = [])
    {
        try {
            $query = $this->queryBuilder->select($this->table)->where($conditions)->getData();

            $stmt = $this->db->prepare($query->sql);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return null;
    }

    public function create(array $data)
    {
        $this->events->trigger("creating.{$this->table}", null, $data);

        $query = $this->queryBuilder->create($this->table, $data)->getData();

        $stmt = $this->db->prepare($query->sql);
        $stmt->execute($query->bind);

        $result = $this->get(['id' => $this->db->lastInsertId()]);

        $this->events->trigger("created.{$this->table}", null, $data);

        return $result;
    }

    public function update(array $conditions, array $data)
    {
        try {
            $this->events->trigger("updating.{$this->table}", null, $data);

            $query = $this->queryBuilder->update($this->table, $data)->where($conditions)->getData();
            $stmt = $this->db->prepare($query->sql);
            $stmt->execute($query->bind);

            $result = $this->get($conditions);

            $this->events->trigger("updated.{$this->table}", null, $result);

            return $result;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        return null;
    }

    public function delete($conditions)
    {
        try {
            $result = $this->get($conditions);

            $this->events->trigger("deleting.{$this->table}", null, $result);

            $query = $this->queryBuilder->delete($this->table)->where($conditions)->getData();

            $stmt = $this->db->prepare($query->sql);
            $stmt->execute($query->bind);

            $this->events->trigger("deleted.{$this->table}", null, $result);

            return $result;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        return null;
    }

}
