<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('/index.html.twig');
    }

    

    // Product controller
    /**
     * @Route("/getproduct", name="productDetail")
     */
    public function listProducts(int $id){
        $products = $this->getDoctrine()
        ->getRepository(Product::class)
        ->findAll([], null, 50);

        shuffle($product);
        $products = array_slice($products, 0, 25);

        $response = new Response();
        $response->setContent(json_encode($products));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}