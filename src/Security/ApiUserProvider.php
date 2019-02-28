<?php

namespace App\Security;

use GuzzleHttp\Client;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use App\Repository\TokenRepository;
use Doctrine\ORM\EntityManagerInterface;

class ApiUserProvider implements UserProviderInterface
{
    private $client;

    public function __construct(Client $client, SerializerInterface $serializer, EntityManagerInterface $manager, TokenRepository $repo, ParameterBagInterface $params)
    {
        $this->client = $client;
        $this->serializer = $serializer;
        $this->manager = $manager;
        $this->repo = $repo;
        $this->params = $params;
    }

    public function loadUserByUsername($username)
    {
        $url = $this->params->get('oAuth_url').$username;
        $response = $this->client->get($url);

        $res = $response->getBody()->getContents();
        $userData = $this->serializer->deserialize($res, 'array', 'json');

        if (!$userData) {
            throw new \LogicException('Did not managed to get your user info from Github.');
        }
        if (!$token = $this->repo->findOneBy(['token' => $username])) {
            throw new \LogicException('The token is not valid !.');
        }
        if (!$token->checkValidity()) {
            throw new \LogicException('The token has expired ! Please login in to get a new token.');
        }
        $client = $token->getClient();



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
