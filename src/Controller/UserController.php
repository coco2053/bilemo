<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationList;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations\Version;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Form\UserType;
use App\Representation\Users;
use App\Repository\UserRepository;

/**
 * This class handles user ressources.
 * @author Bastien Vacherand.
 * @Version("v2")
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
     *
     * @Cache(expires="+5 minutes")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns a list of all users related to an authentified client",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=User::class))
     *     )
     * )
     * @SWG\Parameter(
     *     name="keyword",
     *     in="query",
     *     type="string",
     *     description="Search for a username with a keyword"
     * )
     * @SWG\Tag(name="users")
     * @Security(name="Bearer")
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
     * @Rest\Get(
     *     path = "/api/users/{id}",
     *     name = "user_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
     *
     * @Cache(expires="+5 minutes")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns user details",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=User::class))
     *     )
     * )
     * @SWG\Response(
     *     response=401,
     *     description="Returned when ressource is not yours"
     * )
     * @SWG\Response(
     *     response=404,
     *     description="Returned when ressource is not found"
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     type="integer",
     *     description="id number of the user"
     * )
     * @SWG\Tag(name="users")
     * @Security(name="Bearer")
     */
    public function show(User $user = null, $id)
    {
        if ($user) {
            if ($user->getClient() == $this->getUser()) {
                return $user;
            }
            return new Response('This user is not yours. You are not allowed to see it !', Response::HTTP_UNAUTHORIZED);
        }
        return new Response('No user found with ID '.$id, Response::HTTP_NOT_FOUND);
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
     *
     * @SWG\Response(
     *     response=201,
     *     description="Returns user details",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=User::class))
     *     )
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Returned when a violation is raised by validation"
     * )
     * @SWG\Parameter(
     *     name="User",
     *     in="body",
     *     @Model(type=UserType::class)
     * )
     * @SWG\Tag(name="users")
     * @Security(name="Bearer")
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
     * @SWG\Response(
     *     response=200,
     *     description="User successfully deleted"
     * )
     * @SWG\Response(
     *     response=403,
     *     description="Returned when ressource is not yours"
     * )
     * @SWG\Response(
     *     response=404,
     *     description="Returned when ressource is not found"
     * )
     * @Rest\View
     * @SWG\Tag(name="users")
     * @Security(name="Bearer")
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
        return new Response('No user found with ID '.$id, Response::HTTP_NOT_FOUND);
    }
}
