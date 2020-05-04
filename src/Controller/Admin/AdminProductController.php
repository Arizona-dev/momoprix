<?php
namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminProductController extends AbstractController
{
    
    /**
     * @var ProductRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ProductRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin", name="admin.product.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $products = $this->repository->findAll();
        return $this->render('/admin/product/index.html.twig', compact('products'));
    }

    /**
     * @Route("/admin/product/create", name="admin.product.new")
     */
    public function new(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($product);
            $this->em->flush();
            $this->addFlash('succes', 'Produit crée avec succès');
            return $this->redirectToRoute('admin.product.index');
        }

        return $this->render('/admin/product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/{id}", name="admin.product.edit", methods="GET|POST")
     * @param Product $product
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Product $product, Request $request)
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('succes', 'Produit modifié avec succès');
            return $this->redirectToRoute('admin.product.index');
        }

        return $this->render('/admin/product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/product/{id}", name="admin.product.delete", methods="DELETE")
     */
    public function delete(Product $product, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->get('token'))) {
            $this->em->remove($product);
            $this->em->flush();
            $this->addFlash('succes', 'Produit supprimé avec succès');
        }
        return $this->redirectToRoute('admin.product.index');
        
    }



}