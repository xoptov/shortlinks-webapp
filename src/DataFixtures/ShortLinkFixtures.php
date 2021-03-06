<?php

namespace App\DataFixtures;

use App\Entity\ShortLink;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ShortLinkFixtures extends Fixture implements DependentFixtureInterface
{
    const DATA = [
        [
            'owner' => UserFixtures::REF_USER_LENA,
            'original' => 'https://google.com',
            'slug' => 'GooGLCoM'
        ],
        [
            'owner' => UserFixtures::REF_USER_LENA,
            'original' => 'https://yandex.ru',
            'slug' => 'YaNDeXrU'
        ],
        [
            'owner' => UserFixtures::REF_USER_LENA,
            'original' => 'https://mail.ru',
            'slug' => 'mAilRu'
        ]
    ];

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::DATA as $data) {
            /** @var UserInterface $owner */
            $owner = $this->getReference($data['owner']);
            $shortLink = new ShortLink();
            $shortLink->setOwner($owner)
                ->setOriginal($data['original'])
                ->setSlug($data['slug']);
            $manager->persist($shortLink);
        }
        $manager->flush();
    }

    /**
     * @inheritdoc
     */
    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }
}