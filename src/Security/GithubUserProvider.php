<?php

namespace App\Security;

use GuzzleHttp\Client;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ClientRepository;

class GithubUserProvider implements UserProviderInterface
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

        $client = $this->repo->findOneBy(['username' => $userData['login']]);
        if ($client == null) {
            $client = new \App\Entity\Client(
                $username,
                $userData['login'],
                $userData['name'],
                $userData['email'],
                $userData['avatar_url'],
                $userData['html_url']
            );
            $this->manager->persist($client);
            $this->manager->flush();
            return $client;
        }

        return $client;
    }

    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException();
        }
        return $user;
    }

    public function supportsClass($class)
    {
        return 'Symfony\Component\Security\Core\User\User' === $class;
    }
}
