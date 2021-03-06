<?php

namespace App\Reports\DataLoader;

use App\Entity\User;
use App\Entity\ShortLink;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\EntityManagerInterface;
use App\Reports\Dto\GroupedByDtoInterface;

class GroupedByUsernameDataLoader extends DataLoader
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @inheritdoc
     */
    protected array $supportedGroupedByFields = [
        GroupedByDtoInterface::FIELD_USER
    ];

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritDoc
     */
    public function loadData(GroupedByDtoInterface $dto): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('u.username AS user, COUNT(sl) AS links')
            ->from(User::class, 'u')
            ->join(ShortLink::class, 'sl', Join::WITH, 'u = sl.owner')
            ->groupBy('user')
            ->orderBy('user');

        $query = $queryBuilder->getQuery();

        return $query->getArrayResult();
    }
}
