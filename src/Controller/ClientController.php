<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Product;
use App\Exception\ResourceValidationException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\ConstraintViolationList;

class ClientController extends AbstractFOSRestController
{
    public function list()
    {
        //...
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
}
