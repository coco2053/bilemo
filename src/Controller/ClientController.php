<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        return $this->render('client/admin.html.twig');
    }

    /**
     * @Route("/admin/auth", name="admin_auth")
     */
    public function adminAuth()
    {
        // To avoid the ?code= url. Can be done with Javascript.
        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/admin/logout", name="logout")
     */
    public function logout()
    {
    }
}
