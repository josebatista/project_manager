<?php


namespace App\Models;

use JBP\Framework\QueryBuilder;
use Pimple\Container;

class Users
{
    private $db;
    private $events;
    private $queryBuilder;

    public function __construct(Container $container)
    {
        $this->db = $container['db'];
        $this->events = $container['events'];
        $this->queryBuilder = new QueryBuilder();
    }

    public function get(array $conditions)
    {
        try {
            $query = $this->queryBuilder->select('users')->where($conditions)->getData();

            $stmt = $this->db->prepare($query->sql);
            $stmt->execute($query->bind);

            return $stmt->fetch(\PDO::FETCH_ASSOC);

        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return null;
    }

    public function all()
    {
        $query = $this->queryBuilder->select('users')->getData();

        $stmt = $this->db->prepare($query->sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function create(array $data)
    {
        $this->events->trigger('creating.users', null, $data);

        $query = $this->queryBuilder->create('users', $data)->getData();

        $stmt = $this->db->prepare($query->sql);
        $stmt->execute($query->bind);

        $result = $this->get(['id' => $this->db->lastInsertId()]);

        $this->events->trigger('created.users', null, $data);

        return $result;
    }

    public function update(array $conditions, array $data)
    {
        try {
            $this->events->trigger('updating.users', null, $data);

            $query = $this->queryBuilder->update('users', $data)->where($conditions)->getData();
            $stmt = $this->db->prepare($query->sql);
            $stmt->execute($query->bind);

            $result = $this->get($conditions);

            $this->events->trigger('updated.users', null, $result);

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

            $this->events->trigger('deleting.users', null, $result);

            $query = $this->queryBuilder->delete('users')->where($conditions)->getData();

            $stmt = $this->db->prepare($query->sql);
            $stmt->execute($query->bind);

            $this->events->trigger('deleted.users', null, $result);

            return $result;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        return null;
    }

}
