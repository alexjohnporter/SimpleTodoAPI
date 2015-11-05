<?php

namespace ApplicationBundle\Tests\Controllers\Example;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class HelloWorldTest extends WebTestCase
{
    public function testCreate()
    {
        $client = static::createClient();

        $client->request('GET', '/');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
}
