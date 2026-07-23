<?php

namespace App\Data\Identity;


class UpdateUserData
{
    public function __construct(
        public readonly string $firstName,
        public readonly ?string $middleName,
        public readonly string $lastName,
        public readonly ?string $suffix,
        public readonly string $email,
        public readonly string $password,
    ) {}

    // public static function fromRequest(UpdateUserRequest $request): self
    // {
    //     return new self(
    //         firstName: $request->string('first_name')->toString(),
    //         middleName: $request->filled('middle_name')
    //             ? $request->string('middle_name')->toString()
    //             : null,
    //         lastName: $request->string('last_name')->toString(),
    //         suffix: $request->filled('suffix')
    //             ? $request->string('suffix')->toString()
    //             : null,
    //         email: $request->string('email')->toString(),
    //         password: $request->string('password')->toString(),
    //     );
    // }

    public static function from(array $data): self
    {
        return new self(
            firstName: $data['first_name'],
            middleName: $data['middle_name'] ?? null,
            lastName: $data['last_name'],
            suffix: $data['suffix'] ?? null,
            email: $data['email'],
            password: $data['password'],
        );
    }
}