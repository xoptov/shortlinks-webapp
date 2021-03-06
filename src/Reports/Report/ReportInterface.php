<?php

namespace App\Reports\Report;

interface ReportInterface
{
    /**
     * @param array $row
     */
    public function addRow(array $row): void;

    /**
     * @return array
     */
    public function convertToArray(): array;
}
