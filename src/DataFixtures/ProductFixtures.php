<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\OrderFactory;

use App\Factory\TagFactory;
use App\Factory\ProductFactory;
class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        TagFactory::createOne(['name' => 'Jeux']);
        TagFactory::createOne(['name' => 'Vetements']);
        TagFactory::createOne(['name' => 'Livres']);
        TagFactory::createOne(['name' => 'Sport']);
        TagFactory::createOne(['name' => 'Consoles']);
        TagFactory::createOne(['name' => 'Informatique']);
        TagFactory::createOne(['name' => 'Santé']);
        TagFactory::createOne(['name' => 'Accessoires']);
        TagFactory::createOne(['name' => 'Autres']);

        ProductFactory::createMany(9);
        // for ($i = 1; $i < 10; $i++) {
        //     $product = new Product();
        //     $product
        //     ->setName('Product ' . $i)
        //     ->setDescription('Lorem ispum dolor sit amet')
        //     ->setPrice(mt_rand(10, 100))
        //     ->setDate(\DateTime::createFromFormat('d-m-Y H:i','now'));
        //     $manager->persist($product);
        // }
        $manager->flush();
        }
}