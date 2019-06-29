<?php

namespace App\Controller;

use App\Entity\Client;
use App\Exception\ResourceValidationException;
use App\Representation\Clients;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Http\Discovery\Exception\NotFoundException;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Swagger\Annotations as SWG;

class ClientController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/api/clients", name="app_clients_list")
     * @Rest\QueryParam(
     *     name="keyword",
     *     requirements="[a-zA-Z0-9]",
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
     *     default="10",
     *     description="Max number of clients per page."
     * )
     * @Rest\QueryParam(
     *     name="offset",
     *     requirements="\d+",
     *     default="0",
     *     description="The pagination offset"
     * )
     *
     * @Rest\View(
     *     statusCode=200
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns list of all users related to an authentified user",
     *     @SWG\Schema(
     *     type="array",
     *     @SWG\Items(ref=@Model(type=Client::class))
     * )
     * )
     * @SWG\Parameter(
     *     name="keyword",
     *     in="query",
     *     type="string",
     *     description="Search for a username with a keyword"
     * )
     * @SWG\Tag(name="Clients")
     * @Security(name="Bearer")
     */
    public function list(ParamFetcherInterface $paramFetcher)
    {
        $user = $this->getUser();
        $pager = $this->getDoctrine()->getRepository(Client::class)->search(
            $user->getId(),
            $paramFetcher->get('keyword'),
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );

        return new Clients($pager);
    }

    /**
     * @Rest\Get(
     *     path="/api/clients/{id}",
     *     name="app_client_show",
     *     requirements={"id"="\d+"}
     * )
     *
     * @Rest\View(
     *     statusCode=200
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns client details",
     *     @SWG\Schema(
     *     type="array",
     *     @SWG\Items(ref=@Model(type=Client::class))
     * )
     * )
     * @SWG\Response(
     *     response=403,
     *     description="return when resource is not yours"
     * )
     * @SWG\Response(
     *     response=404,
     *     description="return when resource is not found"
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     type="integer",
     *     description="id of the client"
     * )
     * @SWG\Tag(name="Clients")
     * @Security(name="Bearer")
     */
    public function show(Client $client)
    {
        $this->denyAccessUnlessGranted('SHOW', $client);
        return $client;
    }

    /**
     * @param Client $client
     * @param ConstraintViolationList $violations
     *
     * @throws
     *
     * @Rest\Post(
     *     path="/api/clients",
     *     name="app_client_create"
     * )
     * @Rest\View(statusCode=201)
     * @ParamConverter(
     *     "client",
     *     converter="fos_rest.request_body")
     *
     * @SWG\Response(
     *     response=201,
     *     description="Return user details",
     *     @SWG\Schema(
     *     type="array",
     *     @SWG\Items(ref=@Model(type=Client::class))
     * )
     * )
     *
     * @SWG\Response(
     *     response=400,
     *     description="Return when a violation is raised by validation"
     * )
     *
     * )
     * @SWG\Tag(name="Clients")
     * @Security(name="Bearer")
     */
    public function create(Client $client, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'The JSON sent contains invalid data:';
            foreach ($violations as $violation) {
                $message .= sprintf(
                    "Field %s: %s",
                    $violation->getPropertyPath(),
                    $violation->getMessage()
                );
            }
            throw new ResourceValidationException($message);
        }

        $manager = $this->getDoctrine()->getManager();
        $client->setUser($this->getUser());
        $manager->persist($client);
        $manager->flush();

        return $this->view(
            $client,
            Response::HTTP_CREATED,
            ['Location' => $this->generateUrl(
                'app_client_show',
                [
                    'id' => $client->getId(),
                    UrlGeneratorInterface::ABSOLUTE_URL
                ]
            )]
        );
    }

    /**
     * @param Client $client
     *
     *  @Rest\Patch(
     *     path="/api/clients/{id}",
     *     name="app_client_update",
     *     requirements={"id"="\d+"}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns client details",
     *     @SWG\Schema(
     *     type="array",
     *     @SWG\Items(ref=@Model(type=Client::class))
     * )
     * )
     * @SWG\Response(
     *     response=403,
     *     description="return when resource is not yours"
     * )
     * @SWG\Response(
     *     response=404,
     *     description="return when resource is not found"
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     type="integer",
     *     description="id of the client"
     * )
     * @SWG\Tag(name="Clients")
     * @Security(name="Bearer")
     */
    public function update($id, Request $request)
    {
        $client = $this->getDoctrine()->getRepository(Client::class)->find($id);

        $this->denyAccessUnlessGranted('EDIT', $client);

        if (!$client) {
            throw new NotFoundException('client not found');
        }

        $array = json_decode($request->getContent(), true);
        // sette the user object dynamically
        foreach ($array as $key => $value) {
            $method = 'set'.$key;
            if (preg_match('/_/', $key)) {
                $arrayExp = explode('_', $key);
                foreach ($arrayExp as $entry => $val) {
                    $arrayExpUcF[$entry] = ucfirst($val);
                }

                $method = 'set' . implode($arrayExpUcF);
            }
            if (method_exists($client, $method)) {
                $client->$method($array[$key]);
            } else {
                $view = View::create();
                $view
                    ->setResponse(Response::create($key. ' does not exist', 400))
                    ->setStatusCode(400);

                return $view;
            }
        }

        return $this->view(
            $client,
            Response::HTTP_OK,
            ['Location' => $this->generateUrl(
                'app_client_show',
                [
                    'id' => $client->getId(),
                    UrlGeneratorInterface::ABSOLUTE_URL
                ]
            )]
        );
    }

    /**
     * @param Client $client
     * @return Response
     *
     *  @Rest\Delete(
     *     path="/api/clients/{id}",
     *     name="app_client_delete",
     *     requirements={"id"="\d+"}
     * )
     *
     * * @SWG\Response(
     *     response=204,
     *     description="Client successfully deleted"
     * )
     * @SWG\Response(
     *     response=403,
     *     description="return when resource is not yours"
     * )
     * @SWG\Response(
     *     response=404,
     *     description="return when resource is not found"
     * )
     *
     * @SWG\Tag(name="Clients")
     * @Security(name="Bearer")
     */
    public function delete(Client $client)
    {
        $this->denyAccessUnlessGranted('DELETE', $client);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($client);
        $manager->flush();

        return new Response('Deleted OK', Response::HTTP_OK);
    }
}
