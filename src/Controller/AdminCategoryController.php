<?php
/**
 * Created by PhpStorm.
 * User: ravgus
 * Date: 12.02.19
 * Time: 10:47
 */

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/category")
 */
class AdminCategoryController extends AbstractController
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/", name="admin_category_all")
     */
    public function getAllCategories()
    {
        $categories = $this->categoryRepository->findAll();

        return $this->render('admin/category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/{id}", name="admin_category_current")
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getCurrentCategory(Category $category)
    {
        return $this->render('admin/category/category.html.twig', [
            'category' => $category
        ]);
    }
}