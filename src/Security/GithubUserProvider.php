<?php

namespace App\Security;

use GuzzleHttp\Client;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ClientRepository;
use App\Entity\Token;

class GithubUserProvider implements UserProviderInterface
{
    private $client;

    public function __construct(Client $client, SerializerInterface $serializer, EntityManagerInterface $manager, ClientRepository $repo, ParameterBagInterface $params)
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

        $client = $this->repo->findOneBy(['username' => $userData['login']]);
        if ($client == null) {
            $client = new \App\Entity\Client(
                $userData['login'],
                $userData['name'],
                $userData['email'],
                $userData['avatar_url'],
                $userData['html_url']
            );
            $token = new Token();
            $token->setToken($username);
            $client->setToken($token);
            $this->manager->persist($client, $token);
            $this->manager->flush();
            return $client;
        }
        $token = $client->getToken();
        $token->SetToken($username)
              ->SetCreatedAt(new \DateTime());
        $this->manager->persist($client, $token);
        $this->manager->flush();
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
