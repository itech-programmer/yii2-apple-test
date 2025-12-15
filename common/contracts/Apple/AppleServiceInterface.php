<?php

namespace common\contracts\Apple;

use common\domain\Apple\Apple;

interface AppleServiceInterface
{
    public function list(): array;

    public function generate(int $count): void;

    public function fall(int $id): void;

    public function eat(int $id, float $percent): void;
}
