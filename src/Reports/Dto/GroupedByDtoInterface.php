<?php

namespace App\Reports\Dto;

interface GroupedByDtoInterface
{
    const FIELD_USER = 'user';

    const FIELD_DATE = 'date';

    /**
     * @return array
     */
    public function getFields(): array;

    /**
     * @param string $field
     *
     * @return bool
     */
    public function hasField(string $field): bool;

    /**
     * @return int
     */
    public function getFieldsCount(): int;
}
