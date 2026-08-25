<?php

namespace App\Data;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\LiteralTypeScriptType;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class PasskeyData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $authenticator,
        #[LiteralTypeScriptType('string|null')]
        public ?Carbon $last_used_at,
        #[LiteralTypeScriptType('string|null')]
        public ?Carbon $created_at,
    ) {}
}
