<?php

namespace App\ShortLink\Hasher;

class Sha1Hasher implements HasherInterface
{
    /**
     * @inheritDoc
     */
    public function hash(string $raw): string
    {
        return sha1($raw . microtime());
    }
}