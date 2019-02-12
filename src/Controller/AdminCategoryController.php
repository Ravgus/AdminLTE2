<?php
/**
 * Created by PhpStorm.
 * User: ravgus
 * Date: 12.02.19
 * Time: 10:47
 */

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
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
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    public function __construct(
        CategoryRepository $categoryRepository,
        EntityManagerInterface $entityManager,
        FlashBagInterface $flashBag
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->entityManager = $entityManager;
        $this->flashBag = $flashBag;
    }

    /**
     * @Route("/", name="admin_category_all")
     */
    public function getAllCategories()
    {
        $categories = $this->categoryRepository->findBy([], ['id' => 'ASC']);

        return $this->render('admin/category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/add", name="admin_category_add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addCategory(Request $request)
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            $this->entityManager->persist($category);
            $this->entityManager->flush();

            return $this->redirectToRoute('admin_category_all');
        }

        return $this->render('admin/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Create category'
        ]);
    }

    /**
     * @Route("/edit/{id}", name="admin_category_edit")
     * @param Category $category
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editCategory(Category $category, Request $request)
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            $this->entityManager->flush();

            return $this->redirectToRoute('admin_category_all');
        }

        return $this->render('admin/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Edit category'
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_category_delete")
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteCategory(Category $category)
    {
        $this->entityManager->remove($category);
        $this->entityManager->flush();

        $this->flashBag->add(
            'notice',
            'Category was deleted'
        );

        return $this->redirectToRoute('admin_category_all');
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