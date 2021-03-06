<?php

namespace App\ShortLink\Hasher;

interface HasherInterface
{
    /**
     * @param string $raw
     *
     * @return string
     */
    public function hash(string $raw): string;
}