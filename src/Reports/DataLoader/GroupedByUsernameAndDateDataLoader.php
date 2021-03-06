<?php

namespace App\Reports\DataLoader;

use App\Entity\User;
use App\Entity\ShortLink;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\EntityManagerInterface;
use App\Reports\Dto\GroupedByDtoInterface;

class GroupedByUsernameAndDateDataLoader extends DataLoader
{
    /**
     * @inheritdoc
     */
    protected array $supportedGroupedByFields = [
        GroupedByDtoInterface::FIELD_USER,
        GroupedByDtoInterface::FIELD_DATE
    ];

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param GroupedByDtoInterface $dto
     *
     * @return array
     */
    public function loadData(GroupedByDtoInterface $dto): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('u.username AS user, DATE(sl.createdAt) AS date, COUNT(sl) AS links')
            ->from(User::class, 'u')
            ->join(ShortLink::class, 'sl', Join::WITH, 'u = sl.owner')
            ->groupBy('user')
            ->addGroupBy('date')
            ->orderBy('date')
            ->addGroupBy('user');

        $query = $queryBuilder->getQuery();

        return $query->getArrayResult();
    }
}