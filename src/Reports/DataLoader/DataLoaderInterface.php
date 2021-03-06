<?php

namespace App\Reports\DataLoader;

use App\Reports\Dto\GroupedByDtoInterface;

interface DataLoaderInterface
{
    /**
     * @param GroupedByDtoInterface $dto
     *
     * @return array
     */
    public function loadData(GroupedByDtoInterface $dto): array;

    /**
     * @param GroupedByDtoInterface $dto
     *
     * @return bool
     */
    public function isSupport(GroupedByDtoInterface $dto): bool;
}