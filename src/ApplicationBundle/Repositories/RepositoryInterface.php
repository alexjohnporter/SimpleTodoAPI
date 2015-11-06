<?php

namespace ApplicationBundle\Repositories;
use ApplicationBundle\Entity\SimpleTodo;

/**
 * Interface RepositoryInterface
 * @package ApplicationBundle\Repositories
 */
interface RepositoryInterface
{

    public function find($identifier);

    public function findAll();

    public function create(SimpleTodo $todo);

    public function update(SimpleTodo $todo);

    public function delete($identifier);
}