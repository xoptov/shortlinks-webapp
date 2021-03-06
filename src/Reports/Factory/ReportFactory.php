<?php

namespace App\Reports\Factory;

use App\Reports\Report\Report;
use App\Exception\DataLoaderException;
use App\Reports\Report\ReportInterface;
use App\Reports\Dto\GroupedByDtoInterface;
use App\Reports\DataLoader\DataLoaderInterface;

class ReportFactory implements ReportFactoryInterface
{
    /**
     * @var DataLoaderInterface[]
     */
    private array $dataLoaders = [];

    /**
     * @param GroupedByDtoInterface $dto
     *
     * @return ReportInterface
     *
     * @throws DataLoaderException
     */
    public function create(GroupedByDtoInterface $dto): ReportInterface
    {
        $dataLoader = $this->getAppropriateDataLoader($dto);
        $reportData = $dataLoader->loadData($dto);
        $report = new Report();

        foreach ($reportData as $row) {
            $report->addRow($row);
        }

        return $report;
    }

    /**
     * @param DataLoaderInterface $dataLoader
     */
    public function registerDataLoader(DataLoaderInterface $dataLoader): void
    {
        if (in_array($dataLoader, $this->dataLoaders)) {
            return;
        }
        $this->dataLoaders[] = $dataLoader;
    }

    /**
     * @param GroupedByDtoInterface $dto
     *
     * @return DataLoaderInterface
     *
     * @throws DataLoaderException
     */
    private function getAppropriateDataLoader(
        GroupedByDtoInterface $dto
    ): DataLoaderInterface {
        foreach ($this->dataLoaders as $dataLoader) {
            if ($dataLoader->isSupport($dto)) {
                return $dataLoader;
            }
        }
        throw new DataLoaderException('Can not find appropriate data loader by passed DTO');
    }
}