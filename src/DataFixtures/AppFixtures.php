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

    public function products(ObjectManager $manager) //generate products
    {
        $i = 0;

        foreach (self::PRODUCT_TITLE as $title) {
            $product = new Product();
            $product->setTitle($title);
            $product->setDescription(self::PRODUCT_DESC[rand(0, count(self::PRODUCT_DESC) - 1)]);
            $product->setPrice(rand(0, 5000));
            $product->setCount(rand(0, 100));
            $product->setCategory($this->getReference('t_'.$i)); //bind products with categories
            $i++;

            $manager->persist($product);
        }
    }

    public function categories(ObjectManager $manager) //generate categories
    {
        $i = 0;

        foreach (self::CATEGORY_TITLE as $title) {
            $category = new Category();
            $category->setTitle($title);
            $this->addReference('t_'.$i, $category); //bind products with categories
            $i++;

            $manager->persist($category);
        }
    }

    public function user(ObjectManager $manager) //generate users
    {
        $user1 = new User();

        $user1->setUsername('admin');
        $user1->setPassword($this->userPasswordEncoder->encodePassword($user1, '1')); //generate encrypted password
        $user1->setEmail('admin@admin.com');
        $user1->setFullname('Admin User');
        $user1->setRoles([User::ROLE_ADMIN]);

        $manager->persist($user1);

        $user2 = new User();

        $user2->setUsername('user');
        $user2->setPassword($this->userPasswordEncoder->encodePassword($user2, '1'));
        $user2->setEmail('user@user.com');
        $user2->setFullname('User User');
        $user2->setRoles([User::ROLE_USER]);

        $manager->persist($user2);
    }
}
