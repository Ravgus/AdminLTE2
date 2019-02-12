<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private const CATEGORY_TITLE = [
        'Books',
        'DVD',
        'Games',
        'Toys',
        'Series'
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

    public function load(ObjectManager $manager)
    {
        $this->categories($manager);
        $this->products($manager);

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

        foreach (self::PRODUCT_TITLE as $title) {
            $product = new Product();
            $product->setTitle($title);
            $product->setDescription(self::PRODUCT_DESC[rand(0, count(self::PRODUCT_DESC) - 1)]);
            $product->setPrice(rand(0, 5000));
            $product->setCount(rand(0, 100));

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

        foreach (self::CATEGORY_TITLE as $title) {
            $category = new Category();
            $category->setTitle($title);

            $manager->persist($category);
        }
    }
}
