<?php declare(strict_types=1);

namespace Stratadox\AsciiRenderer;

final class Character
{
    private static Character $NONE;

    public const OPEN = 0;
    public const SEMI = 1;
    public const SOLID = 2;

    public function __construct(
        private string $char,
        private int $solidity,
    ) {
        if ($this->solidity === self::OPEN) {
            $this->char = ' ';
        }
    }

    public static function none(): self
    {
        if (!isset(self::$NONE)) {
            self::$NONE = new self(' ', self::OPEN);
        }
        return self::$NONE;
    }

    public function solidity(): int
    {
        return $this->solidity;
    }

    public function solid(): bool
    {
        return $this->solidity === self::SOLID;
    }

    public function __toString(): string
    {
        return $this->char;
    }

    public function drawOnto(Character $other): Character
    {
        return match ($this->solidity()) {
            self::OPEN => $other,
            self::SEMI => $other->solid() ? $other : $this,
            self::SOLID => $this,
            default => Character::none(),
        };
    }
}
