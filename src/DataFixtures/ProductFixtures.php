<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    private  static $name = [
        'BileMo SG1',
        'BileMo II',
        'BileMo 4g+',
        'BileMo Gold'
        ];

    private static $memory = [
      '2 Go',
      '4 Go',
      '16 Go',
      '64 Go'
    ];

    private static $color = [
      'blue',
      'red',
      'yellow',
      'dark'
    ];

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i <20; $i++) {
            $product = new Product();
            $product->setName('BileMo');
            $product->setMemory('1'.$i.'Go');
            $product->setColor('color'.$i);
            $product->setDescription('description'.$i);
            $product->setWeight('20'.$i. 'gramme');

            $manager->persist($product);
        }

        $manager->flush();
    }
}
