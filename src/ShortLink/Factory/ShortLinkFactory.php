<?php

namespace App\ShortLink\Factory;

use App\Entity\ShortLink;
use Doctrine\ORM\EntityManagerInterface;
use App\ShortLink\SlugGenerator\SlugGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ShortLinkFactory implements ShortLinkFactoryInterface
{
    /**
     * @var SlugGeneratorInterface
     */
    private SlugGeneratorInterface $slugGenerator;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @param SlugGeneratorInterface $slugGenerator
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        SlugGeneratorInterface $slugGenerator,
        EntityManagerInterface $entityManager
    ) {
        $this->slugGenerator = $slugGenerator;
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritDoc
     */
    public function create(
        UserInterface $user,
        string $url,
        ?bool $andFlush = false
    ): ShortLink {

        $slug = $this
            ->slugGenerator
            ->generate($url . $user->getId());

        $shortLink = new ShortLink();
        $shortLink
            ->setOwner($user)
            ->setOriginal($url)
            ->setSlug($slug);

        $this->entityManager->persist($shortLink);

        if (!$andFlush) {
            return $shortLink;
        }

        //todo: тут по хорошему нужно обернуть в try catch так как может попасться не уникальный slug
        $this->entityManager->flush();

        return $shortLink;
    }
}