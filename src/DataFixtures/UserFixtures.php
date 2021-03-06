<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{
    public const REF_USER_LENA  = 'user_lena',
                 REF_USER_MASHA = 'user_masha',
                 REF_USER_DASHA = 'user_dasha';

    const DATA = [
        self::REF_USER_LENA => ['username'  => 'lena',  'token' => 111111111],
        self::REF_USER_MASHA => ['username' => 'masha', 'token' => 222222222],
        self::REF_USER_DASHA => ['username' => 'dasha', 'token' => 333333333]
    ];

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::DATA as $refKey => $data) {
            $user = new User();
            $user
                ->setUsername($data['username'])
                ->setToken($data['token']);
            $manager->persist($user);

            $this->addReference($refKey, $user);
        }
        $manager->flush();
    }
}