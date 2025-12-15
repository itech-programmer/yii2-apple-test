<?php

namespace common\contracts\Apple;

use common\domain\Apple\Apple;

interface AppleRepositoryInterface
{
    public function allWithIds(): array;
    public function getById(int $id): Apple;
    public function save(int $id, Apple $apple): void;
    public function insert(Apple $apple): int;
    public function delete(int $id): void;
}
