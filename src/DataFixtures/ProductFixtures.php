<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < 10; $i++) {
            $product = new Product();
            $product
            ->setName('Product ' . $i)
            ->setDescription('Lorem ispum dolor sit amet')
            ->setPrice(mt_rand(10, 100))
            ->setDate(\DateTime::createFromFormat('d-m-Y H:i','now'));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
