<?php declare(strict_types=1);

namespace Stratadox\AsciiRenderer;

final class Mask
{
    public function __construct(
        private Dimensions $dimensions,
        private array $solidity,
        private array $references,
    ) {}

    public function x1(): int
    {
        return $this->dimensions->x1();
    }

    public function y1(): int
    {
        return $this->dimensions->y1();
    }

    public function x2(): int
    {
        return $this->dimensions->x2();
    }

    public function y2(): int
    {
        return $this->dimensions->y2();
    }

    public function solidityOf(int $x, int $y): int
    {
        return $this->solidity[$y][$x];
    }

    /** @return Coordinate[]|array<string, Coordinate> */
    public function references(): array
    {
        return $this->references;
    }

    public function shifted(int $x, int $y): self
    {
        $shifted = [];
        foreach ($this->solidity as $yy => $line) {
            foreach ($line as $xx => $solidity) {
                $shifted[$yy + $y][$xx + $x] = $solidity;
            }
        }
        return new self($this->dimensions->shifted($x, $y), $shifted, $this->references);
    }
}
