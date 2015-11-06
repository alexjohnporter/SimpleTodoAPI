<?php

namespace ApplicationBundle\Helper;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class SimpleTodoHelper
 * @package ApplicationBundle\Helper
 */
class SimpleTodoHelper
{
    /**
     * Formats database results to an api-friendly array
     *
     * @param array $results
     * @return array
     */
    public function formatResults(array $results)
    {
        $fractal = new Manager();

        $resource = new Collection($results, function (array $results) {
            return [
                'todoIdentifier' => $results['identifier'],
                'todoName' => $results['name'],
                'todoDescription' => $results['description'],
                'todoStatus' => $results['status'],
                'todoCreatedAt' => $results['createdat'],
                'todoUpdatedAt' => $results['updatedat']
            ];
        });

        return $fractal->createData($resource)->toArray();
    }

    /**
     * Transform database result into SimpleTodo object
     *
     * @param $result
     * @return object
     */
    public function deserialize($result)
    {
        return $this->initSerializer()->deserialize(
            $this->initSerializer()->serialize($result, 'json'),
            'ApplicationBundle\Entity\SimpleTodo',
            'json'
        );
    }

    /**
     * Set up the Serializer
     *
     * @return Serializer
     */
    private function initSerializer()
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        return new Serializer($normalizers, $encoders);
    }

}