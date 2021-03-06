<?php

namespace App\Reports\DataLoader;

use App\Reports\Dto\GroupedByDtoInterface;

abstract class DataLoader implements DataLoaderInterface
{
    /**
     * @var array<string>
     */
    protected array $supportedGroupedByFields = [];

    /**
     * @param GroupedByDtoInterface $dto
     *
     * @return bool
     */
    public function isSupport(GroupedByDtoInterface $dto): bool
    {
        if ($dto->getFieldsCount() !== count($this->supportedGroupedByFields)) {
            return false;
        }

        foreach($dto->getFields() as $field) {
            if (!in_array($field, $this->supportedGroupedByFields)) {
                return false;
            }
        }

        return true;
    }
}