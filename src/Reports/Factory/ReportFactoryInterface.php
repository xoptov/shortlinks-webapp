<?php

namespace App\Reports\Factory;

use App\Reports\Report\ReportInterface;
use App\Reports\Dto\GroupedByDtoInterface;
use App\Reports\DataLoader\DataLoaderInterface;

interface ReportFactoryInterface
{
    /**
     * @param GroupedByDtoInterface $dto
     *
     * @return ReportInterface
     */
    public function create(GroupedByDtoInterface $dto): ReportInterface;

    /**
     * @param DataLoaderInterface $dataLoader
     */
    public function registerDataLoader(DataLoaderInterface $dataLoader): void;
}
