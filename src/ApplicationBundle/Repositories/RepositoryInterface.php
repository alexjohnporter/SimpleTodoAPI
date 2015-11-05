<?php

namespace ApplicationBundle\Repositories;

/**
 * Interface RepositoryInterface
 * @package ApplicationBundle\Repositories
 */
interface RepositoryInterface
{

    public function find($identifier);

    public function findAll();

    public function create();

    public function delete($identifier);
}