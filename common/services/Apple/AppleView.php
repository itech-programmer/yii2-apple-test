<?php

namespace common\services\Apple;

final class AppleView
{
    public int $id;

    public function __construct(
        int $id,
        string $color,
        int $status,
        int $createdAtUnix,
        ?int $fellAtUnix,
        float $eatenPercent,
        float $size,
        bool $isRotten
    ) {
        $this->id = $id;
    }
}
