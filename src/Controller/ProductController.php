<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Repository\PhoneRepository;

class ProductController extends AbstractController
{
    /**
     * @Rest\Get("/products", name="product_list")
     *
     * @Rest\View()
     */
    public function list(PhoneRepository $repo)
    {
        $phones = $repo->findAll();

        return $phones;
    }
}
