<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route("/", name="token_claim")
     */
    public function tokenClaim(ParameterBagInterface $params)
    {
        $github_client_id = $params->get('github_client_id');
        return $this->render('client/index.html.twig', ['github_client_id' => $github_client_id]);
    }
}
