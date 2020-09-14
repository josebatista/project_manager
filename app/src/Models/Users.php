<?php


namespace App\Models;

use Pimple\Container;

class Users
{
    private $db;
    private $events;

    public function __construct(Container $container)
    {
        $this->db = $container['db'];
        $this->events = $container['events'];
    }

    public function get($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM `users` WHERE id=?");
        $stmt->execute([$id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function all()
    {
        $stmt = $this->db->prepare("SELECT * FROM `users`");
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function create(array $data)
    {
        $this->events->trigger('creating.users', null, $data);

        $sql = "INSERT INTO `users` (`name`) VALUES (?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_values($data));

        $result = $this->get($this->db->lastInsertId());

        $this->events->trigger('created.users', null, $data);

        return $result;
    }

}
