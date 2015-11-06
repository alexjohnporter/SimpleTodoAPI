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
            return new JsonResponse(
                [
                    'message' => 'No Todos'
                ],
                JsonResponse::HTTP_OK
            );
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
            return new JsonResponse(
                [
                    'error' => 'Missing parameters'
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $result = $this->repository->find($identifier);

        if (empty($result)) {
            return new JsonResponse(
                [
                    'error' => 'Could not find todo'
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
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
            return new JsonResponse(
                [
                    'error' => 'Missing parameters'
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        try {
            $this->repository->create(
                SimpleTodo::createTodo($todoName, $todoDescription)
            );
        } catch (\Exception $e) {
            return new JsonResponse(
                [
                    'error' => 'Todo creation failed'
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
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
            return new JsonResponse(
                [
                    'error' => 'Missing parameters'
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        try {
            $result = $this->repository->find($identifier);
        } catch (\Exception $e) {
            return new JsonResponse(
                [
                    'error' => 'Could not find todo'
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        /** @var SimpleTodo $todo */
        $todo = $this->helper->deserialize($result);
        $todo->setName($request->get('todoName'));
        $todo->setDescription($request->get('todoDescription'));
        $todo->setStatus($request->get('todoStatus'));

        try {
            $this->repository->update($todo);
        } catch (\Exception $e) {
            return new JsonResponse(
                [
                    'error' => 'Could not update todo'
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
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
            return new JsonResponse(
                [
                    'error' => 'Missing parameters'
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        try {
            $this->repository->delete($identifier);
        } catch (\Exception $e) {
            return new JsonResponse(
                [
                    'error' => 'Todo deletion failed'
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        return new JsonResponse(
            [
                'message' => 'Todo deleted'
            ],
            JsonResponse::HTTP_OK
        );
    }

}