<?php declare(strict_types=1);

namespace Stratadox\AsciiRenderer;

final class Dimensions
{
    public function __construct(
        private Coordinate $from,
        private Coordinate $to,
    ) {}

    public function x1(): int
    {
        return $this->from->x();
    }

    public function y1(): int
    {
        return $this->from->y();
    }

    public function x2(): int
    {
        return $this->to->x();
    }

    public function y2(): int
    {
        return $this->to->y();
    }

    public function shifted(int $x, int $y): self
    {
        return new self($this->from->shifted($x, $y), $this->to->shifted($x, $y));
    }
}
