<?php

namespace ApplicationBundle\Controllers;

use ApplicationBundle\Entity\SimpleTodo;
use ApplicationBundle\Helper\SimpleTodoHelper;
use ApplicationBundle\Repositories\RepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SimpleTodoController
 * @package ApplicationBundle\Controllers
 */
class SimpleTodoController
{
    protected $repository;
    protected $helper;

    /**
     * @param RepositoryInterface $repository
     * @param SimpleTodoHelper $helper
     */
    public function __construct(RepositoryInterface $repository, SimpleTodoHelper $helper)
    {
        $this->repository = $repository;
        $this->helper = $helper;
    }


    /**
     * @return JsonResponse
     */
    public function viewAll()
    {
        $results = $this->repository->findAll();

        if (empty($results)) {
            return $this->helper->showError('No Todos');
        }

        return new JsonResponse(
            $this->helper->formatResults($results),
            JsonResponse::HTTP_OK
        );
    }


    /**
     * @param $identifier
     * @return JsonResponse
     */
    public function viewTodo($identifier)
    {
        if (empty($identifier)) {
            return $this->helper->showError('Missing parameters');
        }

        $result = $this->repository->find($identifier);

        if (empty($result)) {
            return $this->helper->showError('Could not find todo');
        }

        return new JsonResponse(
            $this->helper->formatResults([$result]),
            JsonResponse::HTTP_OK
        );
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addTodo(Request $request)
    {
        $todoName = $request->get('todoName');
        $todoDescription = $request->get('todoDescription');

        if (empty($todoName) && empty($todoDescription)) {
            return $this->helper->showError('Missing parameters');
        }

        try {
            $this->repository->create(
                SimpleTodo::createTodo($todoName, $todoDescription)
            );
        } catch (\Exception $e) {
            return $this->helper->showError('Todo creation failed');
        }

        return new JsonResponse(
            [
                'message' => 'Todo created'
            ],
            JsonResponse::HTTP_OK
        );
    }


    public function updateTodo(Request $request, $identifier)
    {
        if (empty($identifier)) {
            return $this->helper->showError('Missing parameters');
        }

        try {
            $result = $this->repository->find($identifier);
        } catch (\Exception $e) {
            return $this->helper->showError('Could not find todo');
        }

        /** @var SimpleTodo $todo */
        $todo = $this->helper->deserialize($result);
        $todo->setName($request->get('todoName'));
        $todo->setDescription($request->get('todoDescription'));
        $todo->setStatus($request->get('todoStatus'));

        try {
            $this->repository->update($todo);
        } catch (\Exception $e) {
            return $this->helper->showError('Could not update todo');
        }

        return new JsonResponse(
            [
                'message' => 'Todo updated'
            ],
            JsonResponse::HTTP_OK
        );
    }


    /**
     * @param $identifier
     * @return JsonResponse
     */
    public function deleteTodo($identifier)
    {
        if (empty($identifier)) {
            return $this->helper->showError('Missing parameters');
        }

        try {
            $this->repository->delete($identifier);
        } catch (\Exception $e) {
            return $this->helper->showError('Todo deletion failed');
        }

        return new JsonResponse(
            [
                'message' => 'Todo deleted'
            ],
            JsonResponse::HTTP_OK
        );
    }

}