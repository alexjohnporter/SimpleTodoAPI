<?php

namespace ApplicationBundle\Repositories;


use Doctrine\DBAL\Driver\Connection;

class SimpleTodoRepository implements  RepositoryInterface
{
    protected $database;

    public function __construct(Connection $database)
    {
        $this->database = $database;
    }

    public function find($identifier)
    {
        // TODO: Implement find() method.
    }

    public function findAll()
    {
        // TODO: Implement findAll() method.
    }

    public function create()
    {
        // TODO: Implement create() method.
    }

    public function delete($identifier)
    {
        // TODO: Implement delete() method.
    }
}