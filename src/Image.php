<?php declare(strict_types=1);

namespace Stratadox\AsciiRenderer;

final class Image
{
    /**
     * @var Mask $mask
     * @var Character[][] $lines
     */
    public function __construct(
        private Mask $mask,
        private array $lines,
    ) {}

    public function characterAt(int $x, int $y): Character
    {
        return $this->lines[$y][$x] ?? Character::none();
    }

    /** @return Coordinate[]|array<string, Coordinate> */
    public function references(): array
    {
        return $this->mask->references();
    }

    public function x1(): int
    {
        return $this->mask->x1();
    }

    public function y1(): int
    {
        return $this->mask->y1();
    }

    public function x2(): int
    {
        return $this->mask->x2();
    }

    public function y2(): int
    {
        return $this->mask->y2();
    }

    public function shifted(int $x, int $y): self
    {
        $shifted = [];
        foreach ($this->lines as $yy => $line) {
            foreach ($line as $xx => $character) {
                $shifted[$yy + $y][$xx + $x] = $character;
            }
        }
        return new self($this->mask->shifted($x, $y), $shifted);
    }

    public function __toString(): string
    {
        return implode(PHP_EOL, array_map(function (array $line): string {
            return implode('', array_map(function (Character $c): string {
                return (string) $c;
            }, $line));
        }, $this->lines));
    }
}
