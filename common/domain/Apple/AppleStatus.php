<?php

namespace common\domain\Apple;

final class AppleStatus
{
    public const ON_TREE = 0;
    public const ON_GROUND = 1;

    public static function isValid(int $status): bool
    {
        return in_array($status, [
            self::ON_TREE,
            self::ON_GROUND,
        ], true);
    }
}
