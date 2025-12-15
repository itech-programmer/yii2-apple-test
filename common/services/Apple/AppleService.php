<?php

namespace common\services\Apple;

use common\contracts\Apple\AppleFactoryInterface;
use common\contracts\Apple\AppleRepositoryInterface;
use common\contracts\Apple\AppleServiceInterface;

final class AppleService implements AppleServiceInterface
{
    public function __construct(
        private AppleRepositoryInterface $repo,
        private AppleFactoryInterface $factory
    ) {}

    public function list(): array
    {
        $now = time();
        $result = [];

        foreach ($this->repo->allWithIds() as $id => $apple) {
            $result[] = new AppleView(
                id: $id,
                color: $apple->color(),
                status: $apple->status(),
                createdAtUnix: $apple->createdAtUnix(),
                fellAtUnix: $apple->fellAtUnix(),
                eatenPercent: $apple->eatenPercent(),
                size: $apple->size(),
                isRotten: $apple->isRotten($now)
            );
        }

        return $result;
    }

    public function generate(int $count): void
    {
        $count = max(1, min($count, 100));

        for ($i = 0; $i < $count; $i++) {
            $this->repo->insert($this->factory->makeRandom());
        }
    }

    public function fall(int $id): void
    {
        $apple = $this->repo->getById($id);
        $apple->fallToGround(time());

        $this->repo->save($id, $apple);
    }

    public function eat(int $id, float $percent): void
    {
        $apple = $this->repo->getById($id);
        $apple->eat($percent, time());

        if ($apple->isFullyEaten()) {
            $this->repo->delete($id);
            return;
        }

        $this->repo->save($id, $apple);
    }
}
