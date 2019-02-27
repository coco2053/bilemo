<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    const TOKEN = 'Bearer 493c687c7a65d0385d9f96a5901b4b45468eefef';

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

        $this->assertSame(200, $client->getResponse()->getStatusCode());

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

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('id', $content);

        $client->request(
            'GET',
            '/api/products/111111',
            [],
            [],
            ['HTTP_Authorization' => self::TOKEN]
        );
        $this->assertSame(404, $client->getResponse()->getStatusCode());
    }
}
