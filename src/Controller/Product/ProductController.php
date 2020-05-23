<?php

namespace App\Controller\Product;

use App\Repository\ProductRepository;
use App\Entity\Product;
use App\Entity\ProductSearch;
use App\Form\ProductSearchType;
use App\Service\Cart\CartService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{

    protected $repository;
    protected $cartService;

    public function __construct(ProductRepository $repository, CartService $cartService)
    {
        $this->repository = $repository;
        $this->cartService = $cartService;
    }


    /**
     * @Route("/courses-en-ligne", name="product.index")
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new ProductSearch();
        $form = $this->createForm(ProductSearchType::class, $search);
        $form->handleRequest($request);

        $products = $paginator->paginate(
            $this->repository->findAllQuery($search),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('/shop.html.twig', [
            'current_menu' => 'shop',
            'products'     => $products,
            'form'         => $form->createView(),
            'items' => $this->cartService->getFullCart(),
            'total' => $this->cartService->getTotal()
        ]);
    }

    /**
     * @Route("/courses-en-ligne/{slug}-{id}", name="product.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Product $product
     * @return Response
     */
    public function show(Product $product, string $slug, int $id): Response
    {
        if ($product->getSlug() !== $slug || $product->getId() !== $id) {
            return $this->redirectToRoute('product.show', [
                'id' => $product->getId(),
                'slug' => $product->getSlug()
            ], 301);
        }
        return $this->render('/product.html.twig', [
            'current_menu' => 'shop',
            'products' => $product,
            'items' => $this->cartService->getFullCart(),
            'total' => $this->cartService->getTotal()
        ]);
    }

}