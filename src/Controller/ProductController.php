<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Repository\PhoneRepository;
use App\Entity\Phone;

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

    /**
     * @Rest\Get(
     *     path = "/products/{id}",
     *     name = "product_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function show(Phone $phone, $id)
    {
        if ($phone) {
            return $phone;
        }

        return new Response('No product found with ID '.$id, Response::HTTP_NOT_FOUND);
    }
}
