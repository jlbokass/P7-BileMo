<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends BaseFixtures
{
    private  static $username = [
        'johndoe',
        'johndoe1',
    ];

    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(User::class, 2, function (User $user) {

            $user->setUsername($this->faker->unique()->randomElement(self::$username));
            $user->setPassword($this->encoder->encodePassword($user, 'test123'));

        });

        $manager->flush();
    }
}
