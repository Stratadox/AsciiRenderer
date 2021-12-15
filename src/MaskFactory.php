<?php declare(strict_types=1);

namespace Stratadox\AsciiRenderer;

final class MaskFactory
{
    private const MAP = [
        ' ' => Character::OPEN,
        '.' => Character::SEMI,
        '#' => Character::SOLID,
    ];

    public function create(Dimensions $dimensions, array $lines, Reference ...$references): Mask
    {
        $solidity = [];
        for ($y = $dimensions->y1(), $sourceY = 0; $y < $dimensions->y2(); $y++, $sourceY++) {
            for ($x = $dimensions->x1(), $sourceX = 0; $x < $dimensions->x2(); $x++, $sourceX++) {
                $solidity[$y][$x] = self::MAP[$lines[$sourceY][$sourceX] ?? ' '] ?? Character::SOLID;
            }
        }
        $refs = [];
        foreach ($references as $reference) {
            foreach ($reference->characters() as $character) {
                foreach ($lines as $y => $line) {
                    $x = strpos($line, $character);
                    if ($x !== false) {
                        $refs[$reference->target()] = new Coordinate($x + $dimensions->x1(), $y + $dimensions->y1());
                        break 2;
                    }
                }
            }
        }
        return new Mask($dimensions, $solidity, $refs);
    }
}
