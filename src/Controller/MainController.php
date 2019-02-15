<?php
/**
 * Created by PhpStorm.
 * User: ravgus
 * Date: 12.02.19
 * Time: 10:30
 */

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
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
     * @Route("/", name="main_index")
     */
    public function index()
    {
        $products = $this->productRepository->findAll();

        return $this->render('index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/buy", name="main_buy")
     */
    public function buy() //some purchase logic
    {
        // TODO It's a stub

        return new Response("Some logic........");
    }
}