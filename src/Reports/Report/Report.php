<?php

namespace App\Reports\Report;

class Report implements ReportInterface
{
    /**
     * @var array
     */
    private array $rows;

    /**
     * @param array $row
     */
    public function addRow(array $row): void
    {
        $this->rows[] = $row;
    }

    /**
     * @return array
     */
    public function convertToArray(): array
    {
        return $this->rows;
    }
}