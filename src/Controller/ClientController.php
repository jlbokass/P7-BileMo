<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Product;
use App\Exception\ResourceValidationException;
use App\Representation\Clients;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\ConstraintViolationList;

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
     */
    public function list(ParamFetcherInterface $paramFetcher)
    {
        $pager = $this->getDoctrine()->getRepository(Client::class)->search(
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
     */
    public function show(Client $client)
    {
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

        $em = $this->getDoctrine()->getManager();
        $em->persist($client);
        $em->flush();

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
     */
    public function update(Client $client)
    {
        $em = $this->getDoctrine()->getManager();
        $em->flush();

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
     * @return Response
     *
     *  @Rest\Delete(
     *     path="/api/clients/{id}",
     *     name="app_client_delete",
     *     requirements={"id"="\d+"}
     * )
     */
    public function delete(Client $client)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($client);
        $em->flush();

        return new Response('Deleted OK', Response::HTTP_OK);
    }
}
