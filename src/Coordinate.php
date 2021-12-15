<?php declare(strict_types=1);

namespace Stratadox\AsciiRenderer;

final class Coordinate
{
    public function __construct(
        private int $x,
        private int $y,
    ) {}

    public function x(): int
    {
        return $this->x;
    }

    public function y(): int
    {
        return $this->y;
    }

    public function shifted(int $x, int $y): self
    {
        return new self($this->x + $x, $this->y + $y);
    }
}
