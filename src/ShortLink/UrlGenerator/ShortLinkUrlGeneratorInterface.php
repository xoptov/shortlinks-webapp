<?php

namespace App\ShortLink\UrlGenerator;

interface ShortLinkUrlGeneratorInterface
{
    /**
     * @param string $slug
     *
     * @return string
     */
    public function generate(string $slug): string;
}