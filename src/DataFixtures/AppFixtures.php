<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\CategoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private const CATEGORY_TITLE = [
        'Books',
        'DVD',
        'Games',
        'Toys',
        'Series',
        'Computers',
        'Food'
    ];

    private const PRODUCT_TITLE = [
        'Barbi',
        'Peace and War',
        'Mister Bin',
        'Railway',
        'Warcraft 3',
        'Doctor House',
        'Hobbit'
    ];

    private const PRODUCT_DESC = [
        'Hello, how are you?',
        'It\'s nice sunny weather today',
        'I need to buy some ice cream!',
        'I wanna buy a new car',
        'There\'s a problem with my phone',
        'I need to go to the doctor',
        'What are you up to today?',
        'Did you watch the game yesterday?',
        'How was your day?'
    ];
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    public function __construct(
        CategoryRepository $categoryRepository,
        UserPasswordEncoderInterface $userPasswordEncoder
     )
    {
        $this->categoryRepository = $categoryRepository;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->categories($manager);
        $this->products($manager);
        $this->user($manager);
        
        $manager->flush();
    }

    public function products(ObjectManager $manager)
    {
        /*for ($i = 0; $i < 30; $i++) {
            $product = new Product();
            $product->setTitle(self::PRODUCT_TITLE[rand(0, count(self::PRODUCT_TITLE) - 1)]);
            $product->setDescription(self::PRODUCT_DESC[rand(0, count(self::PRODUCT_DESC) - 1)]);
            $product->setPrice(rand(0, 5000));
            $product->setCount(rand(0, 100));

            $manager->persist($product);
        }*/

        $i = 0;

        foreach (self::PRODUCT_TITLE as $title) {
            $product = new Product();
            $product->setTitle($title);
            $product->setDescription(self::PRODUCT_DESC[rand(0, count(self::PRODUCT_DESC) - 1)]);
            $product->setPrice(rand(0, 5000));
            $product->setCount(rand(0, 100));
            $product->setCategory($this->getReference('t_'.$i));
            $i++;

            $manager->persist($product);
        }
    }

    public function categories(ObjectManager $manager)
    {
        /*for ($i = 0; $i < 15; $i++) {
            $category = new Category();
            $category->setTitle(self::CATEGORY_TITLE[rand(0, count(self::CATEGORY_TITLE) - 1)]);

            $manager->persist($category);
        }*/

        $i = 0;

        foreach (self::CATEGORY_TITLE as $title) {
            $category = new Category();
            $category->setTitle($title);
            $this->addReference('t_'.$i, $category);
            $i++;

            $manager->persist($category);
        }
    }

    public function user(ObjectManager $manager)
    {
        $user = new User();

        $user->setUsername('admin');
        $user->setPassword($this->userPasswordEncoder->encodePassword($user, '1'));
        $user->setEmail('admin@admin.com');
        $user->setFullname('Admin User');
        $user->setRoles([User::ROLE_ADMIN]);

        $manager->persist($user);
    }
}
