<?php

namespace App\ShortLink\Factory;

use App\Entity\ShortLink;
use Symfony\Component\Security\Core\User\UserInterface;

interface ShortLinkFactoryInterface
{
    /**
     * @param UserInterface $user
     * @param string        $url
     * @param bool          $andFlush
     *
     * @return ShortLink
     */
    public function create(
        UserInterface $user,
        string $url,
        ?bool $andFlush = false
    ): ShortLink;
}
