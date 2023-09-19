<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class TokenDTO extends Data
{
    public function __construct(
        public string $token,
        public int $minutes_to_expire,
    ) {
    }
}
