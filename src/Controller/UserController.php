<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationList;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations\Version;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Representation\Users;
use App\Repository\UserRepository;

/**
 * @Version("2.0")
 */
class UserController extends AbstractController
{
    /**
     * @Rest\Get("/api/users", name="user_list")
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
     *     description="Max number of users per page."
     * )
     * @Rest\QueryParam(
     *     name="offset",
     *     requirements="\d+",
     *     default="1",
     *     description="The pagination offset"
     * )
     * @Rest\View()
     */
    public function list(ParamFetcherInterface $paramFetcher, UserRepository $repo)
    {
        $client = $this->getUser();
        $pager = $repo->search(
            $client->getId(),
            $paramFetcher->get('keyword'),
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );

        return new Users($pager);
    }

    /**
     * @Rest\Post("/api/users")
     * @Rest\View(StatusCode = 201)
     * @ParamConverter(
     *     "user",
     *     converter="fos_rest.request_body",
     *     options={
     *         "validator"={ "groups"="Create" }
     *     }
     * )
     */
    public function add(User $user, EntityManagerInterface $manager, ConstraintViolationList $violations)
    {

        if (count($violations)) {
            $message = 'The JSON sent contains invalid data. Here are the errors you need to correct: ';

            foreach ($violations as $violation) {
                $message .= sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }

            throw new ResourceValidationException($message);
        }
        $user->setClient($this->getUser());
        $user->setRegisteredAt(new \DateTime());
        $manager->persist($user);
        $manager->flush();

        return $user;
    }

    /**
     * @Rest\Delete(
     *     path = "/api/users/{id}",
     *     name = "user_delete",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function delete($id, EntityManagerInterface $manager, UserRepository $repo)
    {
        if ($repo->find($id)) {
            $userD = $repo->find($id);

            if ($userD->getClient() == $this->getUser()) {
                $manager->remove($userD);
                $manager->flush();
                return new Response('User successfully deleted', Response::HTTP_ACCEPTED);
            }
            return new Response('This user is not yours. You are not allowed to delete it !', Response::HTTP_UNAUTHORIZED);
        }
        return new Response('No user found with ID '.$id, Response::HTTP_NO_CONTENT);
    }
}
