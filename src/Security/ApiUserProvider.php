<?php

namespace App\Security;

use GuzzleHttp\Client;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;

class ApiUserProvider implements UserProviderInterface
{
    private $client;

    public function __construct(Client $client, SerializerInterface $serializer, EntityManagerInterface $manager, ClientRepository $repo)
    {
        $this->client = $client;
        $this->serializer = $serializer;
        $this->manager = $manager;
        $this->repo = $repo;
    }

    public function loadUserByUsername($username)
    {
        $url = 'https://api.github.com/user?access_token='.$username;

        $response = $this->client->get($url);
        $res = $response->getBody()->getContents();
        $userData = $this->serializer->deserialize($res, 'array', 'json');

        if (!$userData) {
            throw new \LogicException('Did not managed to get your user info from Github.');
        }

        $client = $this->repo->findOneBy(['token' => $username]);
        if ($client == null) {
            throw new \LogicException('The token is not valid !.');
        }
        return $client;
    }

    public function refreshUser(UserInterface $client)
    {
        $class = get_class($client);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException();
        }

        return $client;
    }

    public function supportsClass($class)
    {
        return 'App\Entity\Client' === $class;
    }
}
