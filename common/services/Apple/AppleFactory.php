<?php

namespace common\services\Apple;

use common\contracts\Apple\AppleFactoryInterface;
use common\domain\Apple\Apple;
use common\domain\Apple\AppleStatus;

final class AppleFactory implements AppleFactoryInterface
{
    private const array COLORS = ['green', 'red', 'yellow'];

    public function makeRandom(): Apple
    {
        $color = self::COLORS[array_rand(self::COLORS)];

        $now = time();
        $created = $now - random_int(0, 7 * 24 * 60 * 60);

        return new Apple(
            color: $color,
            status: AppleStatus::ON_TREE,
            createdAtUnix: $created,
            fellAtUnix: null,
            eatenPercent: 0.0
        );
    }
}
