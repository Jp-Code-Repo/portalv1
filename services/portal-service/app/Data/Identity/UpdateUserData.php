<?php

namespace App\Data\Identity;

use App\Http\Requests\StoreUserRequest;

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

    public static function fromRequest(StoreUserRequest $request): self
    {
        return new self(
            firstName: $request->string('first_name')->toString(),
            middleName: $request->filled('middle_name')
                ? $request->string('middle_name')->toString()
                : null,
            lastName: $request->string('last_name')->toString(),
            suffix: $request->filled('suffix')
                ? $request->string('suffix')->toString()
                : null,
            email: $request->string('email')->toString(),
            password: $request->string('password')->toString(),
        );
    }
}