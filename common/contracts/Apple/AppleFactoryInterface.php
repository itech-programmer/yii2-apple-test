<?php

namespace common\contracts\Apple;

use common\domain\Apple\Apple;

interface AppleFactoryInterface
{
    public function makeRandom(): Apple;
}
