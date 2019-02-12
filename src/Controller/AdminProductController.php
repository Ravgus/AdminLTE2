<?php
/**
 * Created by PhpStorm.
 * User: ravgus
 * Date: 12.02.19
 * Time: 10:47
 */

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/product")
 */
class AdminProductController extends AbstractController
{
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    public function __construct(
        ProductRepository $productRepository,
        EntityManagerInterface $entityManager,
        FlashBagInterface $flashBag
    )
    {
        $this->productRepository = $productRepository;
        $this->entityManager = $entityManager;
        $this->flashBag = $flashBag;
    }

    /**
     * @Route("/", name="admin_product_all")
     */
    public function getAllProducts()
    {
        $products = $this->productRepository->findBy([], ['id' => 'ASC']);

        return $this->render('admin/product/index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/add", name="admin_product_add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addProduct(Request $request)
    {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return $this->redirectToRoute('admin_product_all');
        }

        return $this->render('admin/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Create product'
        ]);
    }

    /**
     * @Route("/edit/{id}", name="admin_product_edit")
     * @param Product $product
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editProduct(Product $product, Request $request)
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $this->entityManager->flush();

            return $this->redirectToRoute('admin_product_all');
        }

        return $this->render('admin/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Edit product'
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_product_delete")
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteProduct(Product $product)
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush();

        $this->flashBag->add(
            'notice',
            'Product was deleted'
        );

        return $this->redirectToRoute('admin_product_all');
    }

    /**
     * @Route("/{id}", name="admin_product_current")
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getCurrentProduct(Product $product)
    {
        return $this->render('admin/product/product.html.twig', [
            'product' => $product
        ]);
    }
}