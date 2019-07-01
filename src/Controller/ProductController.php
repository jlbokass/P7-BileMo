<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Representation\Products;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation as Doc;
use Nelmio\ApiDocBundle\Annotation\Security;

class ProductController extends AbstractController
{
    /**
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return Products
     *
     * @Rest\Get("/api/products", name="app_product_list")
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
     *     description="Max number of article per page."
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
     *     description="Returns list of all products",
     *     @SWG\Schema(
     *     type="array",
     *     @SWG\Items(ref=@Doc\Model(type=Product::class))
     * )
     * )
     *
     * @SWG\Parameter(
     *     name="keyword",
     *     in="query",
     *     type="string",
     *     description="Search for a model with a keyword"
     * )
     * @SWG\Tag(name="Products")
     * @Security(name="Bearer")
     *
     */
    public function list(ParamFetcherInterface $paramFetcher, AdapterInterface $cache): Products
    {
        $pager = $this->getDoctrine()->getRepository(Product::class)->search(
            $paramFetcher->get('keyword'),
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );

        /*$item = $cache->getItem('page');
        if (!$item->isHit()) {
            $item->set($pager);
            $cache->save($item);
        }

        $pager = $item->get();*/

        return new Products($pager);
    }

    /**
     * @Rest\Get(
     *     path="/api/products/{id}",
     *     name="app_product_show",
     *     requirements={"id"="\d+"}
     * )
     *
     * @Rest\View(
     *     statusCode=200
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns product details",
     *     @SWG\Schema(
     *     type="array",
     *     @SWG\Items(ref=@Doc\Model(type=Product::class))
     * )
     * )
     *
     * @SWG\Response(
     *     response=404,
     *     description="return when resource is not found"
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     type="integer",
     *     description="id of the product"
     * )
     * @SWG\Tag(name="Products")
     * @Security(name="Bearer")
     */
    public function show(Product $product)
    {
        return $product;
    }
}
