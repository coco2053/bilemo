<?php

namespace App\Security;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class OauthAuthenticator implements SimplePreAuthenticatorInterface, AuthenticationFailureHandlerInterface
{
    private $client;
    private $clientId;
    private $clientSecret;
    private $router;

    public function __construct(Client $client, $clientId, $clientSecret, Router $router, ParameterBagInterface $params)
    {
        $this->client = $client;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->router = $router;
        $this->params = $params;
    }


    public function createToken(Request $request, $providerKey)
    {
        $code = $request->query->get('code');
        $redirectUri = $this->router->generate('admin_auth', [], ROUTER::ABSOLUTE_URL);
        $url = $this->params->get('oAuth_url').'?code='.$code.'&client_id='.$this->clientId.'&client_secret='.$this->clientSecret.'&grant_type=authorization_code&redirect_uri='.urlencode($redirectUri);

        $response = $this->client->post($url, array(''));
        $res = json_decode($response->getBody()->getContents(), true);

        if (isset($res["error"])) {
            throw new BadCredentialsException('No access_token returned. Start over the process.');
        }

        return new PreAuthenticatedToken(
            'anon.',
            $res['access_token'],
            $providerKey
        );
    }

    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        $accessToken = $token->getCredentials();

        $user = $userProvider->loadUserByUsername($accessToken);
        return new PreAuthenticatedToken(
            $user,
            $accessToken,
            $providerKey,
            ['ROLE_USER']
        );
    }

    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new Response("Authentication Failed :(", 403);
    }
}
