<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClientControllerTest extends WebTestCase
{
    public function testHomepageIsUp()
    {
        $client = static::createClient();
        $client->followRedirects();
        $client->request('GET', '/');

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $crawler = $client->request('GET', '/');
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("BileMo Api")')->count()
        );
    }
    public function testDocIsUp()
    {
        $client = static::createClient();
        $client->followRedirects();
        $client->request('GET', '/doc');

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $crawler = $client->request('GET', '/doc');
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("products")')->count()
        );
    }
}
