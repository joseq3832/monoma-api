<?php

namespace Src\Infraestructure\DTOs;

use Spatie\LaravelData\Data;

class LeadDTO extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $source,
        public int $owner,
        public string $created_at,
        public int $created_by,
    ) {
    }
}
