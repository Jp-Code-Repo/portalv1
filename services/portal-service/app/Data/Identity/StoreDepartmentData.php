<?php

namespace App\Data\Identity;

readonly class StoreDepartmentData
{
    public function __construct(
        public string $code,
        public string $name,
        public ?string $description,
        public bool $isActive,
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