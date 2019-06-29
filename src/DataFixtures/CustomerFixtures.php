<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CustomerFixtures extends BaseFixtures
{
    private  static $username = [
        'johndoe',
        'johndoe1',
    ];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Customer::class, 2, function (Customer $customer) {

            $customer->setUsername($this->faker->unique()->randomElement(self::$username));
            $customer->setPassword('123456');

        });

        $manager->flush();
    }
}
