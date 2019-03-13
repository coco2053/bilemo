<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    const TOKEN = 'Bearer ya29.GlzLBiVzALBi9hvlfvhydJcW1EGQ3aSo5Z68_WusbAa62HobXMmMDHWAVnGdko0AOyvXwHMqEZpML8kD1Y1Jby-f0MNUuPu5OhUZLzyxEgeMbILvWfHuTFOHWoebKQ';

    public function testGetUsersList()
    {
        $client = static::createClient();
        $client->followRedirects();

        $client->request(
            'GET',
            '/api/users',
            [],
            [],
            ['HTTP_Authorization' => self::TOKEN]
        );

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('data', $content);
    }

    public function testGetUsersDetails()
    {
        $client = static::createClient();
        $client->followRedirects();

        $client->request(
            'GET',
            '/api/users/3',
            [],
            [],
            ['HTTP_Authorization' => self::TOKEN]
        );

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $content = json_decode($client->getResponse()->getContent(), true);
        $expected = [
                        "id" => 3,
                        "email" => "elmira.grant@hotmail.com",
                        "username" => "thayes",
                        "avatar_image" => "https://lorempixel.com/64/64/?72926",
                        "registered_at" => "2018-11-20T02:16:27+00:00",
                        "_links" => [
                            "get" => [
                                "href" => "http://localhost/api/users/3"
                            ],
                            "delete" => [
                                "href" => "http://localhost/api/users/3"
                            ]
                        ]
                    ];
        $this->assertSame($expected, $content);
    }

    public function testPostUsers()
    {
        $client = static::createClient();
        $client->followRedirects();

        $faker = \Faker\Factory::create('fr_FR');

        $client->request(
            'POST',
            '/api/users',
            [],
            [],
            ['HTTP_Authorization' => self::TOKEN,
             'CONTENT_TYPE' => 'application/json'],
            '{
                "email": "'.$faker->email().'",
                "username": "'.$faker->userName().'",
                "avatarImage": "'.$faker->imageUrl(64, 64).'"
            }'
        );

        $this->assertSame(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());

        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('id', $content);
    }

    public function testDeleteUsers()
    {
        $client = static::createClient();
        $client->followRedirects();
        $faker = \Faker\Factory::create('fr_FR');
        $client->request(
            'POST',
            '/api/users',
            [],
            [],
            ['HTTP_Authorization' => self::TOKEN,
             'CONTENT_TYPE' => 'application/json'],
            '{
                "email": "'.$faker->email().'",
                "username": "deleteme",
                "avatarImage": "'.$faker->imageUrl(64, 64).'"
            }'
        );

        $params = array('keyword' => 'deleteme');

        $client->request(
            'GET',
            '/api/users',
            $params,
            [],
            ['HTTP_Authorization' => self::TOKEN]
        );
        $content = json_decode($client->getResponse()->getContent(), true);
        $id = $content['data'][0]['id'];

        $client->request(
            'DELETE',
            '/api/users/'.$id,
            [],
            [],
            ['HTTP_Authorization' => self::TOKEN]
        );

        $this->assertSame(Response::HTTP_ACCEPTED, $client->getResponse()->getStatusCode());
    }

    public function testBadRequest()
    {
        $client = static::createClient();
        $client->followRedirects();
        $faker = \Faker\Factory::create('fr_FR');
        $client->request(
            'POST',
            '/api/users',
            [],
            [],
            ['HTTP_Authorization' => self::TOKEN,
             'CONTENT_TYPE' => 'application/json'],
            '{
                "email": "truc@bidule.com",
                "username": "'.$faker->userName().'",
                "avatarImage": "'.$faker->imageUrl(64, 64).'"
            }'
        );

        $this->assertSame(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }

    public function testUnauthorized()
    {
        $client = static::createClient();
        $client->followRedirects();
        $client->request(
            'GET',
            '/api/users/1',
            [],
            [],
            ['HTTP_Authorization' => self::TOKEN]
        );
        $this->assertSame(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());

        $client->request(
            'DELETE',
            '/api/users/1',
            [],
            [],
            ['HTTP_Authorization' => self::TOKEN]
        );

        $this->assertSame(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
    }
}
