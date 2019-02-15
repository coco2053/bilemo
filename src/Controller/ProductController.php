<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Repository\PhoneRepository;
use App\Entity\Phone;
use App\Representation\Phones;

class ProductController extends FOSRestController
{
    /**
     * @Rest\Get("/products", name="product_list")
     * @Rest\QueryParam(
     *     name="keyword",
     *     requirements="[a-zA-Z0-9]+",
     *     nullable=true,
     *     description="The keyword to search for."
     * )
     * @Rest\QueryParam(
     *     name="order",
     *     requirements="asc|desc",
     *     default="asc",
     *     description="Sort order (asc or desc)"
     * )
     * @Rest\QueryParam(
     *     name="limit",
     *     requirements="\d+",
     *     default="15",
     *     description="Max number of products per page."
     * )
     * @Rest\QueryParam(
     *     name="offset",
     *     requirements="\d+",
     *     default="1",
     *     description="The pagination offset"
     * )
     * @Rest\View()
     */
    public function list(ParamFetcherInterface $paramFetcher, PhoneRepository $repo)
    {
        $pager = $repo->search(
            $paramFetcher->get('keyword'),
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );

        return new Phones($pager);
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
