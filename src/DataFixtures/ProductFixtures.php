<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends BaseFixtures
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

    private static $weight = [
        '0.1 Kg',
        '0.2 Kg',
        '0.3 Kg',
    ];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Product::class, 20, function(Product $product){
           $product->
           setName($this->faker->randomElement(self::$name))
           ->setDescription($this->faker->paragraph(10))
           ->setColor($this->faker->randomElement(self::$color))
           ->setMemory($this->faker->randomElement(self::$memory))
           ->setWeight($this->faker->randomElement(self::$weight))
           ;
        });

        $manager->flush();
    }
}
