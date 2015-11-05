<?php

namespace ApplicationBundle\Controllers;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class SimpleTodoController
 * @package ApplicationBundle\Controllers
 */
class SimpleTodoController
{
    public function __construct()
    {

    }
    public function viewAll()
    {

        return new Response('test');
    }

    public function viewTodo($identifier)
    {
        return new Response('test'.$identifier);
    }

    public function addTodo()
    {

    }

    public function updateTodo($identifier)
    {

    }

    public function deleteTodo($identifier)
    {

    }

}