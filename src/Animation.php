<?php declare(strict_types=1);

namespace Stratadox\AsciiRenderer;

final class Animation
{
    /** @var Image[] */
    private array $frames;
    private int $length;

    public function __construct(Image ...$frames)
    {
        $this->frames = $frames;
        $this->length = count($frames);
    }

    public function frame(int $n): Image
    {
        return $this->frames[$n % $this->length];
    }

    public function length(): int
    {
        return $this->length;
    }
}
