<?php

namespace App\Controller;

use App\Entity\Product;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Rest\Get(
     *     path="/products/{id}",
     *     name="app_product_show",
     *     requirements={"id"="\d+"}
     * )
     *
     * @Rest\View(
     *     statusCode=200
     * )
     */
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * @Rest\Get(
     *     path="/products",
     *     name="app_product_list"
     * )
     *
     * @Rest\View(
     *     statusCode=200
     * )
     *
     * @Rest\QueryParam(name="order")
     */
    public function list($order)
    {
        dd($order);
    }
}
