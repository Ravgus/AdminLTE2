<?php
/**
 * Created by PhpStorm.
 * User: ravgus
 * Date: 12.02.19
 * Time: 10:47
 */

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/", name="admin_product_all")
     */
    public function getAllProducts()
    {
        $products = $this->productRepository->findAll();

        return $this->render('admin/product/index.html.twig', [
            'products' => $products
        ]);
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