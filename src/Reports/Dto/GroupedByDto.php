<?php

namespace App\Reports\Dto;

class GroupedByDto implements GroupedByDtoInterface
{
    /**
     * @var array<string>
     */
    private array $fields = [];

    /**
     * @var array<string>
     */
    private array $supportedFields = [
        GroupedByDtoInterface::FIELD_USER,
        GroupedByDtoInterface::FIELD_DATE
    ];

    /**
     * @param array $fields
     */
    public function __construct(array $fields)
    {
        foreach ($fields as $field) {
            if (in_array($field, $this->fields)) {
                continue;
            }
            if (!in_array($field, $this->supportedFields)) {
                continue;
            }
            $this->fields[] = $field;
        }
    }

    /**
     * @return array<string>
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param string $field
     *
     * @return bool
     */
    public function hasField(string $field): bool
    {
        return in_array($field, $this->fields);
    }

    /**
     * @return int
     */
    public function getFieldsCount(): int
    {
        return count($this->fields);
    }
}
