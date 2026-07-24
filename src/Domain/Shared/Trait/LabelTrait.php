<?php

declare(strict_types=1);

namespace App\Domain\Shared\Trait;

/**
 * @property-read string $name
 * @property-read string|int $value
 * @method static array cases()
 */
trait LabelTrait
{
    public function label(): string
    {
        return ucfirst(strtolower($this->name));
    }

    public function labelsByValue(): array
    {
        $result = [];
        foreach (self::cases() as $type) {
            $result[$type->value] = $type->label();
        }

        return $result;
    }
}
