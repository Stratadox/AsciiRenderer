<?php declare(strict_types=1);

namespace Stratadox\AsciiRenderer;

final class ImageFactory
{
    public function from(array $sourceLines, Mask $mask): Image
    {
        $lines = [];
        for ($y = $mask->y1(), $sourceY = 0; $y < $mask->y2(); $y++, $sourceY++) {
            for ($x = $mask->x1(), $sourceX = 0; $x < $mask->x2(); $x++, $sourceX++) {
                $lines[$y][$x] = new Character($sourceLines[$sourceY][$sourceX] ?? ' ', $mask->solidityOf($x, $y));
            }
        }
        return new Image($mask, $lines);
    }
}
