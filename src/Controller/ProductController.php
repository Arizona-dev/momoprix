<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    /**
     * @Route("/view", name="viewProduct")
     */
    public function viewProduct()
    {
        return $this->render('/product.html.twig');
    }
}