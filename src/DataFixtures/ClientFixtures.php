<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

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
            $client->setCreatedAt($this->faker->dateTime);
            $client->setUpdatedAt($this->faker->dateTime);

            /** @var User[] $user */
            $user = $this->getRandomReferences(User::class, $this->faker->numberBetween(1, 2));
            foreach ($user as $user) {
                $client->setUser($user);
            }
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
