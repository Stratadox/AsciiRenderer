<?php declare(strict_types=1);

namespace Stratadox\AsciiRenderer;

final class Reference
{
    /** @var string[] */
    private array $characters;

    public function __construct(
        private string $target,
        string ...$characters
    ) {
        $this->characters = $characters;
    }

    /** @return string[] */
    public function characters(): array
    {
        return $this->characters;
    }

    public function target(): string
    {
        return $this->target;
    }
}
