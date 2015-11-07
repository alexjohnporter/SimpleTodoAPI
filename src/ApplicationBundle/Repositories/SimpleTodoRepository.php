<?php

namespace ApplicationBundle\Repositories;

use ApplicationBundle\Entity\SimpleTodo;
use Doctrine\DBAL\Connection;

/**
 * Class SimpleTodoRepository
 * @package ApplicationBundle\Repositories
 */
class SimpleTodoRepository implements RepositoryInterface
{
    protected $database;

    /**
     * @param Connection $database
     */
    public function __construct(Connection $database)
    {
        $this->database = $database;
    }


    /**
     * @param $identifier
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function find($identifier)
    {
        return $this->database->executeQuery('SELECT * FROM todos WHERE identifier = ?', [$identifier])->fetch();
    }


    /**
     * @return array
     */
    public function findAll()
    {
        return $this->database->fetchAll('SELECT * FROM todos ORDER BY createdat DESC');
    }


    /**
     * @param SimpleTodo $todo
     * @return int
     */
    public function create(SimpleTodo $todo)
    {
        return $this->database->insert('todos',
            [
                'identifier' => $todo->getIdentifier(),
                'name' => $todo->getName(),
                'description' => $todo->getDescription(),
                'status' => $todo->getStatus(),
                'createdat' => $todo->getCreatedAt()->format('Y-m-d H:i:s')
            ]
        );
    }


    /**
     * @param SimpleTodo $todo
     * @return int
     */
    public function update(SimpleTodo $todo)
    {
        $now = new \DateTime('now');

        return $this->database->update('todos',
            [
                'name' => $todo->getName(),
                'description' => $todo->getDescription(),
                'status' => $todo->getStatus(),
                'updatedat' => $now->format('Y-m-d H:i:s')
            ],
            [
                'identifier' => $todo->getIdentifier()
            ]
        );
    }


    /**
     * @param $identifier
     * @return int
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function delete($identifier)
    {
        return $this->database->delete('todos',
            [
                'identifier' => $identifier
            ]
        );
    }
}