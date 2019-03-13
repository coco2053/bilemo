<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ClientControllerTest extends WebTestCase
{
    public function testHomepageIsUp()
    {
        $client = static::createClient();
        $client->followRedirects();
        $client->request('GET', '/');

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $crawler = $client->request('GET', '/');
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Sign In with Google")')->count()
        );
    }
    public function testDocIsUp()
    {
        $client = static::createClient();
        $client->followRedirects();
        $client->request('GET', '/doc');

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $crawler = $client->request('GET', '/doc');
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("products")')->count()
        );
    }
}
