<?php

namespace App\Data\Identity;

class UpdateDepartmentData
{
    public function __construct(
        public readonly string $code,
        public readonly string $name,
        public readonly ?string $description,
        public readonly bool $isActive,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            code: $data['code'],
            name: $data['name'],
            description: $data['description'] ?? null,
            isActive: $data['is_active'],
        );
    }
}