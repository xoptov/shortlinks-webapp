<?php

namespace App\Reports\DataLoader;

use App\Entity\ShortLink;
use Doctrine\ORM\EntityManagerInterface;
use App\Reports\Dto\GroupedByDtoInterface;

class GroupedByDateDataLoader extends DataLoader
{
    /**
     * @inheritdoc
     */
    protected array $supportedGroupedByFields = [
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
            ->select('DATE(sl.createdAt) AS date, COUNT(sl) AS links')
            ->from(ShortLink::class, 'sl')
            ->groupBy('date')
            ->orderBy('date', 'DESC');

        $query = $queryBuilder->getQuery();

        return $query->getArrayResult();
    }
}