<?php

namespace App\ShortLink\SlugGenerator;

interface SlugGeneratorInterface
{
    /**
     * @param string $content
     *
     * @return string
     */
    public function generate(string $content): string;
}