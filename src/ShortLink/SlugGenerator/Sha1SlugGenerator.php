<?php

namespace App\ShortLink\SlugGenerator;

use App\ShortLink\Hasher\HasherInterface;

class Sha1SlugGenerator implements SlugGeneratorInterface
{
    /**
     * @var HasherInterface
     */
    private $hasher;

    const LENGTH_OF_SLUG = 8;

    /**
     * @param HasherInterface $hasher
     */
    public function __construct(HasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * @inheritDoc
     */
    public function generate(string $content): string
    {
        $hash = $this->hasher->hash($content);
        return mb_substr($hash, -self::LENGTH_OF_SLUG, self::LENGTH_OF_SLUG);
    }
}