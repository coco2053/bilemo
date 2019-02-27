<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testProductsListIsUp()
    {
        $client = static::createClient();
        $client->followRedirects();

        $client->request(
            'GET',
            '/api/products',
            [],
            [],
            ['HTTP_Authorization' => 'Bearer 493c687c7a65d0385d9f96a5901b4b45468eefef']
        );

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('data', $content);
        /*$this->assertGreaterThan(
            0,
            $crawler->filter('contains("data")')->count()
        );*/
    }
}
