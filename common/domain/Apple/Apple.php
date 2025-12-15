<?php

namespace common\domain\Apple;

use common\domain\Apple\Exception\AlreadyFallenException;
use common\domain\Apple\Exception\CannotEatMoreThanLeftException;
use common\domain\Apple\Exception\CannotEatOnTreeException;
use common\domain\Apple\Exception\CannotEatRottenAppleException;
use common\domain\Apple\Exception\InvalidEatPercentException;

final class Apple
{
    private const int|float ROTTEN_AFTER_SECONDS = 5 * 60 * 60;
    private string $color;
    private int $status;
    private int $createdAtUnix;
    private ?int $fellAtUnix;
    private float $eatenPercent;

    public function __construct(
        string $color,
        int $status,
        int $createdAtUnix,
        ?int $fellAtUnix,
        float $eatenPercent
    ) {
        $this->eatenPercent = $eatenPercent;
        $this->fellAtUnix = $fellAtUnix;
        $this->createdAtUnix = $createdAtUnix;
        $this->status = $status;
        $this->color = $color;
    }

    /* =======================
       Queries (read methods)
       ======================= */

    public function createdAtUnix(): int
    {
        return $this->createdAtUnix;
    }

    public function fellAtUnix(): ?int
    {
        return $this->fellAtUnix;
    }

    public function color(): string
    {
        return $this->color;
    }

    public function status(): int
    {
        return $this->status;
    }

    public function eatenPercent(): float
    {
        return $this->eatenPercent;
    }

    public function size(): float
    {
        return round(1 - ($this->eatenPercent / 100), 2);
    }

    public function isOnTree(): bool
    {
        return $this->status === AppleStatus::ON_TREE;
    }

    public function isOnGround(): bool
    {
        return $this->status === AppleStatus::ON_GROUND;
    }

    public function isRotten(int $now): bool
    {
        if (!$this->isOnGround()) {
            return false;
        }

        if ($this->fellAtUnix === null) {
            return false;
        }

        return ($now - $this->fellAtUnix) >= self::ROTTEN_AFTER_SECONDS;
    }

    public function isFullyEaten(): bool
    {
        return $this->eatenPercent >= 100;
    }

    /* =======================
       Commands (write methods)
       ======================= */

    public function fallToGround(int $now): void
    {
        if ($this->isOnGround()) {
            throw new AlreadyFallenException();
        }

        $this->status = AppleStatus::ON_GROUND;
        $this->fellAtUnix = $now;
    }

    public function eat(float $percent, int $now): void
    {
        if ($percent <= 0 || $percent > 100) {
            throw new InvalidEatPercentException();
        }

        if ($this->isOnTree()) {
            throw new CannotEatOnTreeException();
        }

        if ($this->isRotten($now)) {
            throw new CannotEatRottenAppleException();
        }

        if ($this->eatenPercent + $percent > 100) {
            throw new CannotEatMoreThanLeftException();
        }

        $this->eatenPercent += $percent;
    }
}
