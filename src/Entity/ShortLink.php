<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="short_link",
 *     indexes={
 *          @ORM\Index(name="IDX_SLUG", columns={"slug"}),
 *          @ORM\Index(name="IDX_CREATED_AT", columns={"created_at"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks
 */
class ShortLink
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private UserInterface $owner;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $original;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $slug;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $createdAt;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return UserInterface|null
     */
    public function getOwner(): ?UserInterface
    {
        return $this->owner;
    }

    /**
     * @param UserInterface $owner
     *
     * @return ShortLink
     */
    public function setOwner(UserInterface $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOriginal(): ?string
    {
        return $this->original;
    }

    /**
     * @param string $original
     *
     * @return ShortLink
     */
    public function setOriginal(string $original): self
    {
        $this->original = $original;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     *
     * @return ShortLink
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist(): void
    {
        $this->createdAt = new DateTimeImmutable();
    }
}
