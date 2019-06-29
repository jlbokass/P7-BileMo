<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ClientFixtures extends BaseFixtures implements DependentFixtureInterface
{
    private  static $username = [
        'john Bokassa',
        'Michael Jordon',
        'karl mallon',
        'Lebron James',
        'Stephen Curry',
        'Kwami Leonard',
        'Steve Kerr',
        'Zion Williamson',
        'Reggie Miller',
        'Magic Johnson',
    ];

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Client::class, 10, function (Client $client) {

            $client->setUsername($this->faker->unique()->randomElement(self::$username));
            $client->setPassword('123456');
            $client->setEmail($this->faker->unique()->email);

            /** @var Customer[] $user */
            $customer = $this->getRandomReferences(Customer::class, $this->faker->numberBetween(1, 2));
            foreach ($customer as $customer) {
                $client->setCustomer($customer);
            }
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CustomerFixtures::class,
        ];
    }
}
