<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProductControllerTest extends WebTestCase
{
    const TOKEN = 'Bearer ya29.GlzLBiVzALBi9hvlfvhydJcW1EGQ3aSo5Z68_WusbAa62HobXMmMDHWAVnGdko0AOyvXwHMqEZpML8kD1Y1Jby-f0MNUuPu5OhUZLzyxEgeMbILvWfHuTFOHWoebKQ';

    public function testGetProductsList()
    {
        $client = static::createClient();
        $client->followRedirects();

        $client->request(
            'GET',
            '/api/products',
            [],
            [],
            ['HTTP_Authorization' => self::TOKEN]
        );

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('data', $content);
    }

    public function testGetProductsDetails()
    {
        $client = static::createClient();
        $client->followRedirects();

        $client->request(
            'GET',
            '/api/products/1',
            [],
            [],
            ['HTTP_Authorization' => self::TOKEN]
        );

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('id', $content);
    }

    public function testNotFound()
    {
        $client = static::createClient();
        $client->followRedirects();
        $client->request(
            'GET',
            '/api/products/111111',
            [],
            [],
            ['HTTP_Authorization' => self::TOKEN]
        );
        $this->assertSame(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }

    public function testAuthorization()
    {
        $client = static::createClient();
        $client->followRedirects();

        $client->request(
            'GET',
            '/api/products',
            [],
            [],
            []
        );

        $this->assertSame(Response::HTTP_INTERNAL_SERVER_ERROR, $client->getResponse()->getStatusCode());
    }
}
