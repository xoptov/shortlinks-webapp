<?php

namespace App\ShortLink\UrlGenerator;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ShortLinkUrlGenerator implements ShortLinkUrlGeneratorInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $urlGenerator;

    /**
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param string $slug
     *
     * @return string
     */
    public function generate(string $slug): string
    {
        return $this->urlGenerator->generate(
            'app_resolve_shortlink',
            ['slug' => $slug],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
    }
}